<?php

namespace Bale\Loker\Http\Controllers\Api\V1;

use Bale\Api\Http\Controllers\Api\BaseApiController;
use Bale\Loker\Models\Loker;
use Bale\Loker\Services\LokerTenantResolver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LokerController extends BaseApiController
{
    /**
     * Daftar loker dari tenant (default: bale disnaker).
     *
     * Hanya menampilkan loker yang aktif dan belum kadaluarsa,
     * diurutkan dari yang terbaru, dengan pagination default 50 per halaman.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $connection = app(LokerTenantResolver::class)->connection();
        } catch (ModelNotFoundException $e) {
            return $this->jsonError($e->getMessage(), 404);
        } catch (\Throwable $e) {
            return $this->jsonError('Unable to connect to the tenant database.', 500);
        }

        $perPage = (int) max(1, min(
            $request->integer('per_page', config('loker.api.per_page', 50)),
            config('loker.api.max_per_page', 100)
        ));

        $lokers = Loker::on($connection)
            ->where('actived', true)
            ->where(function ($query) {
                $query->whereNull('tgl_berakhir')
                    ->orWhereDate('tgl_berakhir', '>=', today());
            })
            ->orderByDesc('created_at')
            ->paginate($perPage);

        $lokers->setCollection(
            $lokers->getCollection()->map(fn (Loker $loker) => $loker->toArray() + [
                'is_expired' => (bool) $loker->is_expired,
            ])
        );

        return $this->jsonPaginated($lokers);
    }
}
