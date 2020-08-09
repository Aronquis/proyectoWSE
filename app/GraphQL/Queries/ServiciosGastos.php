<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class ServiciosGastos
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
    public function GetAllServiciosGastos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $servicios_gastos=DB::table('DbWSE.dbo.ServiciosGastos')
            ->paginate($perPage = $args['number_paginate'], $columns = ['*'], $pageName = 'page', $page = $args['page']);
        foreach($servicios_gastos as $servicios){
            $servicios->Servicios=DB::table('DbWSE.dbo.Servicios')->where('IdServicio',$servicios->IdServicio)->first();
            $servicios->TipoDocumento=DB::table('DbWSE.dbo.TipoDocumentos')->where('IdTipoDoc',$servicios->IdTipoDoc)->first();
            $servicios->TipoGastos=DB::table('DbWSE.dbo.TipoGastos')->where('IdTipoGasto',$servicios->IdTipoGasto)->first();
            $servicios->TipoMoneda=DB::table('DbWSE.dbo.TipoMonedas')->where('IdMoneda',$servicios->IdMoneda)->first();
            $servicios->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$servicios->IdUsuario)->first();
        }
        return ['NroItems'=>$servicios_gastos->total(),'data'=>$servicios_gastos];
    }
    public function GetServiciosGastos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $servicios_gastos=DB::table('DbWSE.dbo.Servicios')
                ->where('DbWSE.dbo.Servicios.IdServicio',$args['IdServicio'])
                ->select('DbWSE.dbo.Servicios.*')
                ->first();
        @$servicios_gastos->ServiciosGastos=DB::table('DbWSE.dbo.ServiciosGastos')->where('IdServicio',$servicios_gastos->IdServicio)->get();
        foreach(@$servicios_gastos->ServiciosGastos as $servicios){
            $servicios->TipoDocumento=DB::table('DbWSE.dbo.TipoDocumentos')->where('IdTipoDoc',$servicios->IdTipoDoc)->first();
            $servicios->TipoMoneda=DB::table('DbWSE.dbo.TipoMonedas')->where('IdMoneda',$servicios->IdMoneda)->first();
            $servicios->TipoGastos=DB::table('DbWSE.dbo.TipoGastos')->where('IdTipoGasto',$servicios->IdTipoGasto)->first();
            $servicios->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$servicios->IdUsuario)->first();
        }
        return $servicios_gastos;
    }
    public function GetServiciosGastosDetalle($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $servicios_gastos=DB::table('DbWSE.dbo.ServiciosGastos')->where('IdGasto',$args['IdGasto'])->first();
        @$servicios_gastos->Servicios=DB::table('DbWSE.dbo.Servicios')->where('IdServicio',$servicios_gastos->IdServicio)->first();
        @$servicios_gastos->TipoDocumento=DB::table('DbWSE.dbo.TipoDocumentos')->where('IdTipoDoc',$servicios_gastos->IdTipoDoc)->first();
        @$servicios_gastos->TipoMoneda=DB::table('DbWSE.dbo.TipoMonedas')->where('IdMoneda',$servicios_gastos->IdMoneda)->first();
        @$servicios_gastos->TipoGastos=DB::table('DbWSE.dbo.TipoGastos')->where('IdTipoGasto',$servicios_gastos->IdTipoGasto)->first();
        @$servicios_gastos->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$servicios_gastos->IdUsuario)->first();
        return $servicios_gastos;
    }
}
