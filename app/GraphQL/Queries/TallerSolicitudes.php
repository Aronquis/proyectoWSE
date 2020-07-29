<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class TallerSolicitudes
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
    public function GetAllTallerSolicitudes($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $taller_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudes')
            ->where('estado','like','%'.$args['estado'].'%')
            ->paginate($perPage = $args['number_paginate'], $columns = ['*'], $pageName = 'page', $page = $args['page']);
        foreach($taller_solicitudes as $taller){
            $taller->TallerSolicitudesTipos=DB::table('DbWSE.dbo.TallerSolicitudesTipos')->where('IdTipo',$taller->IdTipo)->first();
            $taller->Placas=DB::table('DbWSE.dbo.Placas')->where('ID',$taller->IdPlaca)->first();
            $taller->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$taller->IdUsuario)->first();
        }
        return ['NroItems'=>$taller_solicitudes->total(),'data'=>$taller_solicitudes];
    }
    public function GetDetalleTallerSolicitudes($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $taller_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudes')
            ->where('IdSolicitud','like','%'.$args['IdSolicitud'].'%')
            ->first();
        @$taller_solicitudes->TallerSolicitudesTipos=DB::table('DbWSE.dbo.TallerSolicitudesTipos')->where('IdTipo',$taller_solicitudes->IdTipo)->first();
        @$taller_solicitudes->Placas=DB::table('DbWSE.dbo.Placas')->where('ID',$taller_solicitudes->IdPlaca)->first();
        @$taller_solicitudes->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$taller_solicitudes->IdUsuario)->first();
        return $taller_solicitudes;
    }
}
