<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Address;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $user->fill($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                ],
            'phone' => [
                'nullable',
                'string',
                'max:11',
            ],
        ]));
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function addressForm(Request $request): View
    {
        $user = $request->user();
        return view('profile.addAddress', ['address' => $user->address,]);
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');

            // Save image path to user's profile
            $user->image = '/storage/' . $imagePath;
            $user->save();

            return redirect()->back()->with('success', 'Avatar updated successfully.');
        }

        return redirect()->back()->with('error', 'No image was uploaded.');
    }

    public function saveAddress(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'isdefault' => 'nullable|boolean',
        ]);

        $user = $request->user();

        if (isset($data['isdefault']) && $data['isdefault']) {
            $user->address()->update(['isdefault' => 1]);
        }
        $data['user_id'] = $user->id;

        $user->address()->create($data);

        return Redirect::route('profile.addAddress')->with('status', 'address-saved');
    }
    public function trackOrder(Request $request): View
    {
        $user = $request->user();

        $transactions = Transaction::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $orders = Order::where('user_id', $user->id)
                        ->with('orderItems.product')
                        ->get();

        return view('profile.trackorder', [
            'transactions' => $transactions,
            'orders' => $orders,
        ]);
    }

    public function cancelOrder($orderId): RedirectResponse
    {
        $order = Order::find($orderId);
        $transaction = Transaction::where('order_id', $order->id)->first();
        if ($transaction) {
            $transaction->status = 'cancelled';
            $transaction->save();
        }
        $order->cancellation_date = now();
        $order->save();

        return redirect()->route('profile.trackorder')->with('success', 'Order cancelled successfully.');
    }
    public function viewOrderDetails($orderId): View
    {
        $order = Order::find($orderId);

        $orderItems = OrderItem::where('order_id', $orderId)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $orderId)->first();
        $user = auth()->user();

       return view('profile.viewOrderDetails', compact('order', 'orderItems', 'transaction', 'user'));
    }
}
