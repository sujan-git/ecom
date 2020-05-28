<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Repositories\Category\CategoryRepository;
use Exception;

class CategoryController extends Controller
{
    //
    public function __construct(CategoryRepository $category,Category $model){
    	$this->category = $category;
        $this->model = $model;
    }

    public function add(){
        $parent_cats = $this->model->where('parent_id',NULL)->get();
    	return view('category.add')->with('parent_cats',$parent_cats);
    }
    /*public function store(Request $request){
    	$act = 'add';
    	$rules = $this->category->getRules();
    	$validate = $request->validate($rules);
    	$data = $request->except(['_token']);
    	$data['slug'] = $this->category->getSlug($request->title);
    	$this->category->fill($data);
    	$success = $this->category->save();
        dd($success);
    	if($success){
    		$request->session()->flash('success', 'Category '.$act.'ed successfully.');
    	}else{
    		$request->session()->flash('error', 'Sorry! Category could not be '.$act.'ed at this moment.');
    	}
    	return redirect()->route('category-list');
    }*/

    public function store(Request $request){
        //dd($request);
        $rules = $this->model->getRules();
        $request->validate($rules);
        try {

            $this->category->create( $request->all() );
            \Session::flash('success','Category Saved successfully');

        }catch ( Exception $e ) {
            \Session::flash('error','Unable to Add Category At This Moment...Internal ERROR');
        }
        
        return redirect()->route('category-list');

    }

    public function list(){
    	$cats = $this->model->get();
        //dd($cats);
    	return view('category.list')->with('categories',$cats);
    }
    
    public function edit($id){
        $category = $this->category->getById( $id );
        //dd($category);
        return view( 'category.edit' )->with( [
            'parent_cats' => $this->model->where('parent_id',NULL)->where('id','!=', $id)->get(),
            'category'           => $category
        ] );
    }

    public function update(Request $request,$id){
        //dd($request);
        $rules = $this->model->getRules();
        //d($rules);
        $request->validate($rules);
        try{
            
            $this->category->update( $id, $request->all() );
            $name = $this->model->where('id',$id)->get();
            \Session::flash('success','Category-->'. $name[0]->title .' Updated successfully');

       } catch ( Exception $e ) {

            //throw new Exception( 'Error in updating category: ' . $e->getMessage() );
            \Session::flash('error','Unable to Update Category At This Moment...Internal ERROR');
        }

        return redirect()->route('category-list');
    }

    public function delete($id){
        $childs = $this->model->where('parent_id',$id)->get();
         if(isset($childs) && $childs!=NULL){
            foreach($childs as $child){
                $this->category->delete($child->id);
            }
        }
        $this->category->delete( $id );
        return redirect()->back()->with( 'success', 'Category and Sub Categories are Successfully deleted!!' );

    }

    public function getChild($id){
        $child = $this->model->where('parent_id',$id)->get();
        return response()->json($child);
    }
}
