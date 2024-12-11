<?php

namespace App\Services;

use App\Enums\LogStatusEnum;
use App\Models\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Mantax559\LaravelHelpers\Helpers\SessionHelper;

class LogService
{
    public function list(array $filter): LengthAwarePaginator
    {
        session()->put(SessionHelper::getUrlKey(Log::class), request()->fullUrl());

        return Log::query()
            ->when(isset($filter['search']), fn ($q) => $q->whereLike(['code', 'description'], $filter['search']))
            ->when(isset($filter['status']), fn ($q) => $q->where('status', $filter['status']))
            ->orderByDesc('id')
            ->paginate(setting('paginate'))
            ->onEachSide(setting('on_each_side'));
    }

    public function store(string $description, LogStatusEnum $logStatusEnum): Log
    {
        return Log::create([
            'status' => $logStatusEnum,
            'code' => $this->generateUniqueCode(),
            'description' => $description,
        ]);
    }

    public function destroy(Log $log): void
    {
        $log->delete();
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = mt_rand(pow(10, Log::CODE_LENGTH), pow(10, Log::CODE_LENGTH + 1) - 1);
        } while (Log::where('code', $code)->exists());

        return $code;
    }
}
