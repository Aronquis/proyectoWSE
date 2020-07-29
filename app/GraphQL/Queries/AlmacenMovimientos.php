<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class AlmacenMovimientos
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function GetAllAlmacenMovimientos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $almacen_movimientos=DB::table('DbWSE.dbo.AlmacenMovimientos')
        ->where('IdMotivo','like','%'.$args['IdMotivo'].'%')
        ->paginate($perPage = $args['number_paginate'], $columns = ['*'], $pageName = 'page', $page = $args['page']);
        foreach($almacen_movimientos as $almacen){
            $almacen->Producto=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$almacen->IdProducto)->first();
            $almacen->Placa=DB::table('DbWSE.dbo.Placas')->where('ID',$almacen->IdPlaca)->first();
            $almacen->AlmacenMotivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->where('IdMotivo',$almacen->IdMotivo)->first();
        }
        return ['NroItems'=>$almacen_movimientos->total(),'data'=>$almacen_movimientos];
    }
    public function GetDetalleAlmacenMovimientos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $almacen_movimientos=DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['id'])->first();
        @$almacen_movimientos->Producto=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$almacen_movimientos->IdProducto)->first();
        @$almacen_movimientos->Placa=DB::table('DbWSE.dbo.Placas')->where('ID',$almacen_movimientos->IdPlaca)->first();
        @$almacen_movimientos->AlmacenMotivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->where('IdMotivo',$almacen_movimientos->IdMotivo)->first();
        return $almacen_movimientos;
    }
}
