<?php

namespace App\Providers;

use Collective\Html\FormBuilder;
use Illuminate\Support\ServiceProvider;

class FormBuilderProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBootstrapForms();
    }
    public function registerBootstrapForms()
    {
      FormBuilder::component("bsText","forms.bs.text",['name', 'old' , 'value' => null, 'attributes' => []]);
      FormBuilder::component("bsSelect","forms.bs.select",['name', 'old', 'values' => [], "value"=>null, 'attributes' => []]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
