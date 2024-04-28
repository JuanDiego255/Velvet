<?php

namespace App\Http\Controllers;

use App\Models\TenantCarousel;
use App\Models\TenantInfo;
use App\Models\TenantSocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TenantInfoController extends Controller
{
    protected $expirationTime;

    public function __construct()
    {
        // Define el tiempo de expiración en minutos
        $this->expirationTime = 60; // Por ejemplo, 60 minutos
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Cache::remember('tenant_info_data', $this->expirationTime, function () {
            $tenant_info = TenantInfo::get();
            $tenantsocial = TenantSocialNetwork::get();
            $tenantcarousel = TenantCarousel::get();
            return compact('tenant_info', 'tenantsocial', 'tenantcarousel');
        });
        return view('admin.tenant-info.index', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexComponents()
    {
        //
        $data = Cache::remember('tenant_info_data', $this->expirationTime, function () {
            $tenant_info = TenantInfo::get();
            return compact('tenant_info');
        });
        return view('admin.tenant-info.components', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $campos = [
                'title' => 'required|string|max:1000',
                'mision' => 'required|string|max:1000',
                'title_suscrib_a' => 'required|string|max:1000',
                'description_suscrib' => 'required|string|max:1000',
                'footer' => 'required|string|max:1000',
                'whatsapp' => 'required|string|max:1000',
                'sinpe' => 'required|string|max:1000'
            ];

            $mensaje = ["required" => 'El :attribute es requerido store'];
            $this->validate($request, $campos, $mensaje);

            $tenantinfo =  new TenantInfo();
            if ($request->hasFile('logo')) {
                $tenantinfo->logo = $request->file('logo')->store('uploads', 'public');
            }
            if ($request->hasFile('login_image')) {
                $tenantinfo->login_image = $request->file('login_image')->store('uploads', 'public');
            }

            $tenantinfo->title = $request->title;
            $tenantinfo->title_discount = $request->title_discount;
            $tenantinfo->title_instagram = $request->title_instagram;
            $tenantinfo->mision = $request->mision;
            $tenantinfo->title_trend = $request->title_trend;
            $tenantinfo->title_suscrib_a = $request->title_suscrib_a;
            $tenantinfo->description_suscrib = $request->description_suscrib;
            $tenantinfo->footer = $request->footer;
            $tenantinfo->whatsapp = $request->whatsapp;
            $tenantinfo->sinpe = $request->sinpe;
            $tenantinfo->count = $request->count;
            $tenantinfo->email = $request->email;
            $tenantinfo->delivery = $request->delivery;

            $tenantinfo->save();
            DB::commit();
            return redirect('/tenant-info')->with(['status' => 'Se ha guardado la información del negocio', 'icon' => 'success']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect('/tenant-info')->with(['status' => 'No se pudo guardar la información del negocio', 'icon' => 'error']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {
            $campos = [
                'title' => 'required|string|max:1000',
                'mision' => 'required|string|max:1000',
                'title_suscrib_a' => 'required|string|max:1000',
                'description_suscrib' => 'required|string|max:1000',
                'footer' => 'required|string|max:1000',
                'whatsapp' => 'required|string|max:1000',
                'sinpe' => 'required|string|max:1000'

            ];

            $mensaje = ["required" => 'El :attribute es requerido ' . $id . ' update'];
            $this->validate($request, $campos, $mensaje);
            $tenantinfo = TenantInfo::first();
            if (!isset($tenantinfo)) {
                $this->store($request);
            }
            if ($request->hasFile('logo')) {
                Storage::delete('public/' . $tenantinfo->logo);
                $logo = $request->file('logo')->store('uploads', 'public');
                $tenantinfo->logo = $logo;
            }
            if ($request->hasFile('login_image')) {
                Storage::delete('public/' . $tenantinfo->login_image);
                $login_image = $request->file('login_image')->store('uploads', 'public');
                $tenantinfo->login_image = $login_image;
            }
            $tenantinfo->title = $request->title;
            $tenantinfo->title_discount = $request->title_discount;
            $tenantinfo->title_instagram = $request->title_instagram;
            $tenantinfo->mision = $request->mision;
            $tenantinfo->title_trend = $request->title_trend;
            $tenantinfo->title_suscrib_a = $request->title_suscrib_a;
            $tenantinfo->description_suscrib = $request->description_suscrib;
            $tenantinfo->footer = $request->footer;
            $tenantinfo->whatsapp = $request->whatsapp;
            $tenantinfo->sinpe = $request->sinpe;
            $tenantinfo->count = $request->count;
            $tenantinfo->email = $request->email;
            $tenantinfo->delivery = $request->delivery;
            $tenantinfo->update();
            DB::commit();
            return redirect('/tenant-info')->with(['status' => 'Se ha editado la información del negocio con éxito', 'icon' => 'success']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect('/tenant-info')->with(['status' => 'No se pudo guardar la información del negocio', 'icon' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::beginTransaction();
        try {

            $tenantinfo = TenantInfo::findOrfail($id);
            if (
                Storage::delete('public/' . $tenantinfo->logo)
                && Storage::delete('public/' . $tenantinfo->login_image)
            ) {
                TenantInfo::destroy($id);
            }
            TenantInfo::destroy($id);
            DB::commit();
            return redirect('/tenant-info')->with(['status' => 'Se ha eliminado la información del negocio', 'icon' => 'success']);
        } catch (\Exception $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateComp(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            $tenantinfo = TenantInfo::first();            
            $tenantinfo->manage_size = $request->manage_size ? 1 : 0;
            $tenantinfo->manage_department = $request->manage_department ? 1 : 0;
            $tenantinfo->show_stock = $request->show_stock ? 1 : 0;
            $tenantinfo->show_trending = $request->show_trending ? 1 : 0;
            $tenantinfo->show_insta = $request->show_insta ? 1 : 0;
            $tenantinfo->show_mision = $request->show_mision ? 1 : 0;
            $tenantinfo->show_cintillo = $request->show_cintillo ? 1 : 0;
            $tenantinfo->update();
            DB::commit();
            return redirect()->back()->with(['status' => 'Se ha editado la visualización de componentes', 'icon' => 'success']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['status' => 'No se pudo guardar la información del negocio', 'icon' => 'error']);
        }
    }
}
