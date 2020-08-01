<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class Productos
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
    public function GetAllAlmacenLineas($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $LineaProductos=DB::table('DbWSE.dbo.vAlmacenLineas')
            ->where('Activo','=',1)
            ->get();
        return $LineaProductos;
    }
    public function GetAllProductos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $productos=DB::table('DbWSE.dbo.AlmacenProductos')
            ->where('IdLinea','like','%'.$args['IdLinea'].'%')
            ->paginate($perPage = $args['number_paginate'], $columns = ['*'], $pageName = 'page', $page = $args['page']);
        foreach($productos as $producto){
            $producto->AlmacenLineas=DB::table('DbWSE.dbo.vAlmacenLineas')->where('IdLinea',$producto->IdLinea)->first();
        }
        return ['NroItems'=>$productos->total(),'data'=>$productos];
    }
    public function GetProductosDetalle($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $productos=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$args['IdProducto'])->first();
        return $productos;
    }
}
