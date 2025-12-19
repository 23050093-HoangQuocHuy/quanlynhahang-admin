<?php

/**
 * Helper functions cho Role
 */

if (!function_exists('getRoleConstants')) {
    /**
     * Lấy danh sách role constants
     */
    function getRoleConstants(): array
    {
        return config('roles', []);
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Kiểm tra user có phải admin không
     */
    function isAdmin($user = null): bool
    {
        $user = $user ?? auth()->user();
        if (!$user || !$user->role) {
            return false;
        }
        return $user->role->name === config('roles.ROLE_ADMIN', 'admin');
    }
}

if (!function_exists('isCashier')) {
    /**
     * Kiểm tra user có phải cashier không
     */
    function isCashier($user = null): bool
    {
        $user = $user ?? auth()->user();
        if (!$user || !$user->role) {
            return false;
        }
        return $user->role->name === config('roles.ROLE_CASHIER', 'cashier');
    }
}

if (!function_exists('isWaiter')) {
    /**
     * Kiểm tra user có phải waiter không
     */
    function isWaiter($user = null): bool
    {
        $user = $user ?? auth()->user();
        if (!$user || !$user->role) {
            return false;
        }
        return $user->role->name === config('roles.ROLE_WAITER', 'waiter');
    }
}

if (!function_exists('isKitchen')) {
    /**
     * Kiểm tra user có phải kitchen không
     */
    function isKitchen($user = null): bool
    {
        $user = $user ?? auth()->user();
        if (!$user || !$user->role) {
            return false;
        }
        return $user->role->name === config('roles.ROLE_KITCHEN', 'kitchen');
    }
}

