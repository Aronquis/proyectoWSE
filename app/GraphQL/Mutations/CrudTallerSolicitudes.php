<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class CrudTallerSolicitudes
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
    public function Create($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        @$taller_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudes')->get()->last();
        DB::table('DbWSE.dbo.TallerSolicitudes')->insert([
            'IdSolicitud'=> @$taller_solicitudes->IdSolicitud+1,
            'FechaRegistro'=>$args['FechaRegistro'],
            'IdTipo'=>$args['IdTipo'],
            'Detalle'=>$args['Detalle'],
            'Kilometraje'=>$args['Kilometraje'],
            'IdPlaca'=>$args['IdPlaca'],
            'Estado'=>1,
            'IdUsuario'=>$args['IdUsuario']
        ]);
        $taller_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudes')->get()->last();
        @$taller_solicitudes->TallerSolicitudesTipos=DB::table('DbWSE.dbo.TallerSolicitudesTipos')->where('IdTipo',$taller_solicitudes->IdTipo)->first();
        @$taller_solicitudes->Placas=DB::table('DbWSE.dbo.Placas')->where('ID',$taller_solicitudes->IdPlaca)->first();
        @$taller_solicitudes->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$taller_solicitudes->IdUsuario)->first();
        return $taller_solicitudes;
    }
    public function Update($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        ///estados 
        ///pendiente:1
        ///valido:2
        //invalido:3
        if(isset($args['Estado'])==true){
            DB::table('DbWSE.dbo.TallerSolicitudes')->where('IdSolicitud',$args['IdSolicitud'])->update([
                'Estado'=>$args['Estado'],
            ]);

        }
        else{
            DB::table('DbWSE.dbo.TallerSolicitudes')->where('IdSolicitud',$args['IdSolicitud'])->update([
                'FechaRegistro'=>$args['FechaRegistro'],
                'IdTipo'=>$args['IdTipo'],
                'Detalle'=>$args['Detalle'],
                'Kilometraje'=>$args['Kilometraje'],
                'IdPlaca'=>$args['IdPlaca'],
                'IdUsuario'=>$args['IdUsuario']
            ]);
        }
        $taller_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudes')->where('IdSolicitud',$args['IdSolicitud'])->first();
        @$taller_solicitudes->TallerSolicitudesTipos=DB::table('DbWSE.dbo.TallerSolicitudesTipos')->where('IdTipo',$taller_solicitudes->IdTipo)->first();
        @$taller_solicitudes->Placas=DB::table('DbWSE.dbo.Placas')->where('ID',$taller_solicitudes->IdPlaca)->first();
        @$taller_solicitudes->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$taller_solicitudes->IdUsuario)->first();
        return $taller_solicitudes;
    }
    public function Delete($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
       
        $taller_solicitudes=DB::table('DbWSE.dbo.TallerSolicitudes')->where('IdSolicitud',$args['IdSolicitud'])->delete();
        
        return "Exito";
    }
}
