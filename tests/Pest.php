<?php

use Bale\Loker\Tests\TestCase;
use Tests\Concerns\RefreshTestDatabaseSafely;

uses(TestCase::class, RefreshTestDatabaseSafely::class)->in('Feature');
