<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = CustomerAddress::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = auth()->user();

            $hasAddress = CustomerAddress::where('user_id', $user->id)
                ->exists();

            CustomerAddress::create([
                ...$validated,
                'user_id' => $user->id,
                'is_default' => !$hasAddress,
            ]);
        });

        return redirect()
            ->route('customer.addresses.index')
            ->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $address = CustomerAddress::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = CustomerAddress::where('user_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $address->update($validated);

        return redirect()
            ->route('customer.addresses.index')
            ->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $address = CustomerAddress::where('user_id', auth()->id())
                ->lockForUpdate()
                ->findOrFail($id);

            $wasDefault = $address->is_default;
            $userId = $address->user_id;

            $address->delete();

            if ($wasDefault) {
                $newDefault = CustomerAddress::where('user_id', $userId)
                    ->oldest()
                    ->first();

                if ($newDefault) {
                    $newDefault->update(['is_default' => true]);
                }
            }
        });

        return redirect()
            ->route('customer.addresses.index')
            ->with('success', 'Alamat berhasil dihapus.');
    }

    public function setDefault($id)
    {
        DB::transaction(function () use ($id) {
            $address = CustomerAddress::where('user_id', auth()->id())
                ->lockForUpdate()
                ->findOrFail($id);

            CustomerAddress::where('user_id', auth()->id())
                ->update(['is_default' => false]);

            $address->update(['is_default' => true]);
        });

        return redirect()
            ->route('customer.addresses.index')
            ->with('success', 'Alamat utama berhasil diperbarui.');
    }
}
