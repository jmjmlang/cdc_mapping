<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserApprovalController extends Controller
{
    /**
     * Show all pending (and recent) citizen account registrations + all users table.
     */
    public function index(): View
    {
        $pending = User::with('barangay')
            ->where('role', 'citizen')
            ->where('account_status', 'pending')
            ->latest()
            ->get();

        $recent = User::with('barangay')
            ->where('role', 'citizen')
            ->whereIn('account_status', ['approved', 'rejected'])
            ->latest()
            ->take(20)
            ->get();

        $statusOrder = ['pending' => 0, 'approved' => 1, 'rejected' => 2];

        $allUsers = User::with('barangay')
            ->latest()
            ->get()
            ->sortBy(fn ($u) => $statusOrder[$u->account_status] ?? 9)
            ->values();

        $barangays = Barangay::orderBy('name')->get();

        return view('pages.admin.users.index', compact('pending', 'recent', 'allUsers', 'barangays'));
    }

    /**
     * Approve a citizen's account registration.
     */
    public function approve(User $user): RedirectResponse
    {
        abort_if($user->role !== 'citizen', 403);

        $user->update(['account_status' => 'approved']);

        return back()->with('success', "{$user->name}'s account has been approved.");
    }

    /**
     * Reject a citizen's account registration.
     */
    public function reject(User $user): RedirectResponse
    {
        abort_if($user->role !== 'citizen', 403);

        $user->update(['account_status' => 'rejected']);

        return back()->with('success', "{$user->name}'s account has been rejected.");
    }

    /**
     * Update a user's information (admin can edit name, email, role, barangay, reset password).
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:191'],
            'email'        => ['required', 'email', 'max:191', "unique:users,email,{$user->id}"],
            'role'         => ['required', 'in:admin,citizen'],
            'org_role'     => ['nullable', 'in:Local Health Worker,SPUP-CDC,Doctor'],
            'barangay_id'  => ['nullable', 'exists:barangays,id'],
            'new_password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->update([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'role'        => $validated['role'],
            'org_role'    => $validated['role'] === 'admin' ? ($validated['org_role'] ?? null) : null,
            'barangay_id' => $validated['barangay_id'] ?? null,
        ]);

        if (! empty($validated['new_password'])) {
            $user->update(['password' => Hash::make($validated['new_password'])]);
        }

        return back()->with('success', "{$user->name}'s information has been updated.");
    }

    /**
     * Toggle a user's role between admin and citizen.
     */
    public function toggleRole(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $newRole = $user->role === 'admin' ? 'citizen' : 'admin';
        $oldRole = $user->role;
        $user->update(['role' => $newRole]);

        // Store first name + last initial only (e.g. "John Michael T.")
        $shortName = preg_replace('/\s+(\S)\S*$/', ' $1.', $user->name);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'role_changed',
            'properties' => [
                'target_id'   => $user->id,
                'target_name' => $shortName,
                'old_role'    => $oldRole,
                'new_role'    => $newRole,
            ],
        ]);

        return back()->with('success', "{$user->name} is now " . ($newRole === 'admin' ? 'an Admin' : 'a Citizen') . ".");
    }
}
