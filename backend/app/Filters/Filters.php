<?php
namespace App\Filters;

use Illuminate\Http\Request;
abstract class Filters {
  protected $request, $builder;

  protected $filters = [];
  public function __construct(Request $request) {
    $this->request = $request;
  }
  public function apply($builder) {
    // Apply filters to the builder

    $this->builder = $builder;

    

      foreach($this->getFilters() as $filter => $value){
        if(method_exists($this, $filter)){
          $this->$filter($value);
        }
    }
   
      //$user = User::where('name', $username)->firstOrFail();

      return $this->builder;
    
  }
  public function getFilters() {
    return $this->request->intersect($this->filters);
  }
  // protected function hasFilter($filter): bool {
  //   return $this->request->has($filter);
  // }
}