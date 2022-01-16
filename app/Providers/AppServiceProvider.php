<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register a few Eloquent macros

        /**
         * search the closest fit
         */
        Builder::macro('search', function( $field, $value ){
            if( $value ) {
                return $this->where( function ( $query ) use ( $field, $value ) {
                    $value ? $query->where( $field, 'LIKE', '%' . $value . '%' ) : true;
                } );
            }
            return $this;
        });

        /**
         * search strict matches
         */
        Builder::macro('strictSearch', function( $field, $value ){
            if( $value ) {
                return $this->where( function ( $query ) use ( $field, $value ) {
                    $value ? $query->where( $field, $value ) : true;
                } );
            }
            return $this;
        });

        /**
         * where less than
         */
        Builder::macro('lessThan', function ( $field,  $value ){
            if( $value ) {
                return $this->where( function ( $query ) use ( $field, $value ) {
                    $value ? $query->where( $field, '<', $value ) : true;
                } );
            }
            return $this;
        });

        /**
         * where greater than
         */
        Builder::macro('greaterThan', function ( $field,  $value ){
            if( $value ) {
                return $this->where( function ( $query ) use ( $field, $value ) {
                    $value ? $query->where( $field, '>', $value ) : true;
                } );
            }
            return $this;
        });


    }
}
