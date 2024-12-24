<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\menuContent;
use App\Http\Requests\StoremenuRequest;
use App\Http\Requests\UpdatemenuRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //
        $cari = $request->cari;
        if(!empty($cari)){
            $query = Menu::query();
            $columns = ['menuName', 'menuLink'];
            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $cari . '%');
            }
            $tables = $query->paginate(10);
        }else{
            $tables = Menu::paginate(10);
        }
        $title = 'Hapus Role!';
        $text = "Apakah anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('menu.view', ['table' => $tables]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $beritakat= menu::get();
        return view('menu.tambah',[
            'beritakat' =>$beritakat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoremenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoremenuRequest $request)
    {
        //
        $fileName = time().'_'.$request->file("icon")->getClientOriginalName();
        $filePath = $request->file('icon')->storeAs('uploads/icon', $fileName, 'public');
        $name = time().'_'.$request->file("icon")->getClientOriginalName();
        echo $name;
        // print_r(Str::slug( $request->get("menuName")));
        $ids= menu::insertGetId([
            "icon" => $name,
            "menuName" => $request->get("menuName"),
            "menuLink" => $request->get("menuLink"),
            "parent" => $request->get("parent"),
            "publish" => $request->get("publish"),
            "creator" => $request->get("creator"),
            ]
        );
        menuContent::create([
            "menuCode" => $ids,
            "menucontent" => "",
        ]);
        return redirect()->route('menu.index')->withSuccess("jabatan baru berhasil di tambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(menu $menu)
    {
        $menudata = menuContent::where("menuCode" , $menu->menuCode)->first();
        return view('menu.show', [
            'single' => $menu,
            'menudata' => $menudata
        ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(menu $menu)
    {
        //
        $beritakat= menu::get();
        return view('menu.edit',[
            'single' => $menu ,
            'beritakat' =>$beritakat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemenuRequest  $request
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatemenuRequest $request, menu $menu)
    {
        //

        if($request->file("icon")){
            $fileName = time().'_'.$request->file("icon")->getClientOriginalName();
            $filePath = $request->file('icon')->storeAs('uploads/icon', $fileName, 'public');
            $name = time().'_'.$request->file("icon")->getClientOriginalName();
        $menu->update([
            "icon" => $name,
            "menuName" => $request->get("menuName"),
            "menuLink" => $request->get("menuLink"),
            "parent" => $request->get("parent"),
            "publish" => $request->get("publish"),
            "creator" => $request->get("creator"),
            ]);
        return redirect()->back()
        ->withSuccess('Product is updated successfully.');
        }else{
            
          $menu->update([
            "menuName" => $request->get("menuName"),
            "menuLink" => $request->get("menuLink"),
            "parent" => $request->get("parent"),
            "publish" => $request->get("publish"),
            "creator" => $request->get("creator"),
          ]);
          return redirect()->back()
          ->withSuccess('Product is updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(menu $menu)
    {
        //
        $menu->delete();
        return redirect()->back()
                ->withSuccess('Berhasil Dihapus');
    }

    public function menucontent(Request $request){
        print_r($request->all());

        menuContent::where("id" , $request->id)->update([
            "menucontent" => $request->menucontent
        ]);  return redirect()->back()
        ->withSuccess('is updated successfully.');

    }
}
