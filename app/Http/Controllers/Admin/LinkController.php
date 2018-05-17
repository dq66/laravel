<?php

namespace App\Http\Controllers\Admin;

use App\Model\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * Notes:友情链接首页
     * User:Administrator
     * Date:2018/5/5
     * Time:10:31
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $links = Link::paginate(10);
        return view("admin.links.index",compact('links'));
    }

    /**
     * Notes:添加友情
     * User:Administrator
     * Date:2018/5/5
     * Time:11:10
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request){

        $file = $request->file('avatar');

        if($file->isValid()){
            $filename = $file->getClientOriginalName();//客户端文件名称
            $entension = $file -> getClientOriginalExtension();   //上传文件的后缀.
            $newName = md5(date('ymdhis').$filename).".".$entension;    //定义上传文件的新名称
            $path = $file->move('uploads', $newName);//把缓存文件移动到制定文件夹

            $links = Link::create([
                "title" => $request->post('title'),
                "avatar" => $path,
                "connect" => $request->post('connect'),
                "describe" => $request->post('describe')
            ]);
        }

        return Prompt($links,"添加友情","Admin/link");
    }

    /**
     * Notes:删除友情
     * User:Administrator
     * Date:2018/5/5
     * Time:11:52
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id){

        if($request->isMethod('post')){
            //dd($request->all());
            //判断是否有图片上传
            if(\Request::instance()->file()){
                $file = $request->file('avatar');
                $filename = $file->getClientOriginalName();//客户端文件名称
                $entension = $file -> getClientOriginalExtension();   //上传文件的后缀.
                $newName = md5(date('ymdhis').$filename).".".$entension;    //定义上传文件的新名称
                $path = $file->move('uploads', $newName);//把缓存文件移动到制定文件夹
                $data = array(
                    "title" => $request->post('title'),
                    "avatar" => $path,
                    "connect" => $request->post('connect'),
                    "describe" => $request->post('describe')
                );
            }else{
                $data = array(
                    "title" => $request->post('title'),
                    "avatar" => $request->post('yimg'),
                    "connect" => $request->post('connect'),
                    "describe" => $request->post('describe')
                );
            }

            $links = Link::where("id","=",$id)->update($data);
            return Prompt($links,"修改友情","Admin/link");

        }else{

            $links = Link::find($id);
            return view("admin.links.edit",compact('links'));
        }

    }

    /**
     * Notes:删除友情
     * User:Administrator
     * Date:2018/5/5
     * Time:11:54
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $links = Link::where("id","=",$id)->delete();
        return Prompt($links,"删除友情","Admin/link");
    }
}
