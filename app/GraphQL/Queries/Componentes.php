<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class Componentes
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
    public function GetPlacas($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $placas=DB::table('DbWSE.dbo.Placas')->get();
        return $placas;
    }
    public function GetServicios($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $servicios=DB::table('DbWSE.dbo.Servicios')->get();
        return $servicios;
    }
    public function GetTipoDocumento($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tipo_documento=DB::table('DbWSE.dbo.TipoDocumentos')->get();
        return $tipo_documento;
    }
    public function GetTipoGasto($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tipo_gastos=DB::table('DbWSE.dbo.TipoGastos')->get();
        return $tipo_gastos;
    }
    public function GetTipoMoneda($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tipo_moneda=DB::table('DbWSE.dbo.TipoMonedas')->get();
        return $tipo_moneda;
    }
    public function GetTipoUnidadGasto($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tipo_unidad_gasto=DB::table('DbWSE.dbo.TipoUnidadGasto')->get();
        return $tipo_unidad_gasto;
    }
    public function GetTallerSolicitudesTipos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $taller_tipo_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudesTipos')->get();
        return $taller_tipo_solicitudes;
    }
    public function GetProveedores($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $proveedores=DB::table('DbWSE.dbo.Proveedores')->get();
        return $proveedores;
    }
    public function GetAlmacenMotivos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $almacen_motivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->get();
        return $almacen_motivos;
    }
}
