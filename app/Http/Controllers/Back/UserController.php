<?php

namespace App\Http\Controllers\Back;

use App\{Models\User, Http\Controllers\Controller};
use App\Helpers\ImageHelper;
use App\Http\Requests\UserRequest;
use App\Models\Query;
use App\Models\Subscriber;
use App\Repositories\Front\UserRepository;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param  \App\Repositories\Back\UserRepository $repository
     *
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware("auth:admin");
        $this->middleware("adminlocalize");
        $this->middleware("permissions:Update Customers|Manage Merchants")->only(["update"]);
        $this->middleware("permissions:Delete Customers")->only([
            "getContactDelete",
        ]);
        $this->middleware("permissions:Delete Customers|Delete Merchants")->only([
            "destroy",
        ]);
        $this->middleware("permissions:Customer List")->only([
            "index",
            "getContactSupport",
        ]);
        $this->middleware("permissions:Customer List|Manage Merchants")->only([
            "show",
        ]);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("back.user.index", [
            "datas" => User::where("is_merchant", 0)->latest()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view("back.user.show", compact("user"));
    }

    public function update(UserRequest $request)
    {
        $request->validate([
            "password" => "min:6|max:16|nullable",
        ]);
        $this->repository->profileUpdate($request);
        return redirect()
            ->back()
            ->withSuccess(__("Profile Updated Successfully."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isMerchant = $user->is_merchant;
        ImageHelper::handleDeletedImage($user, "photo", "images");
        $user->delete();
        
        if ($isMerchant) {
            return redirect()
                ->route("back.merchant.index")
                ->withSuccess(__("Merchant Deleted Successfully."));
        }

        return redirect()
            ->route("back.user.index")
            ->withSuccess(__("Customer Deleted Successfully."));
    }

    /**
     * Contact Support
     *
     *
     */
    public function getContactSupport()
    {
        $queries = Query::all();
        return view("back.support.contact", compact("queries"));
    }

    public function getContactDelete($id)
    {
        $query = Query::findOrFail($id);
        $query->delete();
        return redirect()->back();
    }
}
