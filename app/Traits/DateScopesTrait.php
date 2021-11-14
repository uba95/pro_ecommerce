<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateScopesTrait {

    public function scopeWhereToday($q) {
        return $q->where($this->getTable() . '.' . 'created_at', '>=', today())
        ->where($this->getTable() . '.' . 'created_at', '<', Carbon::tomorrow());
        // return $q->whereBetween($this->getTable() . '.' . 'created_at', [today(), today()->endOfDay()]);
    }

    public function scopeThisMonth($q) {
        return $q->where($this->getTable() . '.' . 'created_at', '>=', now()->firstOfMonth())
        ->where($this->getTable() . '.' . 'created_at', '<', now()->addMonth()->firstOfMonth());
        // return $q->whereBetween($this->getTable() . '.' . 'created_at', [now()->firstOfMonth(), now()->endOfMonth()]);
    }

    public function scopeThisYear($q) {
        return $q->where($this->getTable() . '.' . 'created_at', '>=', now()->firstOfYear())
        ->where($this->getTable() . '.' . 'created_at', '<', now()->addYear()->firstOfYear());
        // return $q->whereBetween($this->getTable() . '.' . 'created_at', [now()->firstOfYear(), now()->endOfYear()]);
        // return $q->whereYear($this->getTable() . '.' . 'created_at', now()->year);
    }

    public function scopeLastdays($q, $days = 30) {
        return $q->where($this->getTable() . '.' . 'created_at', '>=', now()->subDays($days))
        ->where($this->getTable() . '.' . 'created_at', '<', now());
        // return $q->whereBetween($this->getTable() . '.' . 'created_at', [now()->subDays(30), now()]);
        // return $q->whereDate($this->getTable() . '.' . 'created_at', '>', now()->subDays(30));
    }

    public function scopeDateRange($q, $from, $to) {
        return $q->where($this->getTable() . '.' . 'created_at', '>=', $from)
        ->where($this->getTable() . '.' . 'created_at', '<', $to);
    }
}