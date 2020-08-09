<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class CrudServiciosGastos
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
        $nameCreate="";
        if(isset($args['Foto'])==true){
            $image = $args['Foto'];
            $arrNameFile = explode(".", $image->getClientOriginalName());
            $extension = $arrNameFile[sizeof($arrNameFile) - 1];
            $fileName = str_replace(' ', '',$arrNameFile[0]);
            //////////////////////////////7777
            //////////////validar nonbres
            $nombre=DB::table('DbWSE.dbo.ServiciosGastos')->where('DbWSE.dbo.ServiciosGastos.Foto',$fileName. '.' .$extension)->first();
           
            $fileNameNuevo=$fileName;
            $i=1;
            while (isset($nombre->id)==true) {
                $nombre=DB::table('DbWSE.dbo.ServiciosGastos')->where('DbWSE.dbo.ServiciosGastos.Foto',$fileName.'('.$i.')'.'.'.$extension)->first();
                $fileNameNuevo=$fileName.'('.$i.')';
                $i+=1; 
            }
            /////////////////////////////////
            $nameCreate =$fileNameNuevo. '.' .'webp';
            $image->storeAs('FotosServiciosGastos/', $nameCreate, 'local');
        }
        DB::table('DbWSE.dbo.ServiciosGastos')->insert([
            'IdTipoGasto'=>$args['IdTipoGasto'],
            'IdServicio'=>$args['IdServicio'],
            'IdProveedor'=>$args['IdProveedor'],
            'IdTipoDoc'=>$args['IdTipoDoc'],
            'Serie'=>$args['Serie'],
            'Numero'=>$args['Numero'],
            'Fecha'=>$args['Fecha'],
            'Cantidad'=>$args['Cantidad'],
            'IdUnidad'=>$args['IdUnidad'],
            'Detalle'=>$args['Detalle'],
            'IdMoneda'=>$args['IdMoneda'],
            'Importe'=>$args['Importe'],
            'FechaRegistro'=>date("Y-m-d").'T'.date("H:i:s"),
            'IdUsuario'=>$args['IdUsuario'],
            'Foto'=>$nameCreate
        ]);
        $servicios_gastos=DB::table('DbWSE.dbo.ServiciosGastos')->get()->last();
        @$servicios_gastos->Servicios=DB::table('DbWSE.dbo.Servicios')->where('IdServicio',$servicios_gastos->IdServicio)->first();
        @$servicios_gastos->TipoDocumento=DB::table('DbWSE.dbo.TipoDocumentos')->where('IdTipoDoc',$servicios_gastos->IdTipoDoc)->first();
        @$servicios_gastos->TipoMoneda=DB::table('DbWSE.dbo.TipoMonedas')->where('IdMoneda',$servicios_gastos->IdMoneda)->first();
        @$servicios_gastos->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$servicios_gastos->IdUsuario)->first();
        return $servicios_gastos;

    }
    public function Update($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if(isset($args['Foto'])==true){
            $image = $args['Foto'];
            $arrNameFile = explode(".", $image->getClientOriginalName());
            $extension = $arrNameFile[sizeof($arrNameFile) - 1];
            $fileName = str_replace(' ', '',$arrNameFile[0]);
            //////////////////////////////7777
            //////////////validar nonbres
            $nombre=DB::table('DbWSE.dbo.ServiciosGastos')->where('DbWSE.dbo.ServiciosGastos.Foto',$fileName. '.' .$extension)->first();
           
            $fileNameNuevo=$fileName;
            $i=1;
            while (isset($nombre->id)==true) {
                $nombre=DB::table('DbWSE.dbo.ServiciosGastos')->where('DbWSE.dbo.ServiciosGastos.Foto',$fileName.'('.$i.')'.'.'.$extension)->first();
                $fileNameNuevo=$fileName.'('.$i.')';
                $i+=1; 
            }
            /////////////////////////////////

            $nameCreate =$fileNameNuevo. '.' .'webp';
            $image->storeAs('FotosServiciosGastos/', $nameCreate, 'local');
            DB::table('DbWSE.dbo.ServiciosGastos')->where('DbWSE.dbo.ServiciosGastos.IdGasto',$args['IdGasto'])->Update([
                'Foto'=>$nameCreate,
            ]); 
        }
        DB::table('DbWSE.dbo.ServiciosGastos')->where('IdGasto',$args['IdGasto'])->update([
            'IdTipoGasto'=>$args['IdTipoGasto'],
            'IdServicio'=>$args['IdServicio'],
            'IdProveedor'=>$args['IdProveedor'],
            'IdTipoDoc'=>$args['IdTipoDoc'],
            'Serie'=>$args['Serie'],
            'Numero'=>$args['Numero'],
            'Fecha'=>$args['Fecha'],
            'Cantidad'=>$args['Cantidad'],
            'IdUnidad'=>$args['IdUnidad'],
            'Detalle'=>$args['Detalle'],
            'IdMoneda'=>$args['IdMoneda'],
            'Importe'=>$args['Importe'],
            'IdUsuario'=>$args['IdUsuario'],
        ]);
        $servicios_gastos=DB::table('DbWSE.dbo.ServiciosGastos')->where('IdGasto',$args['IdGasto'])->first();
        @$servicios_gastos->Servicios=DB::table('DbWSE.dbo.Servicios')->where('IdServicio',$servicios_gastos->IdServicio)->first();
        @$servicios_gastos->TipoDocumento=DB::table('DbWSE.dbo.TipoDocumentos')->where('IdTipoDoc',$servicios_gastos->IdTipoDoc)->first();
        @$servicios_gastos->TipoMoneda=DB::table('DbWSE.dbo.TipoMonedas')->where('IdMoneda',$servicios_gastos->IdMoneda)->first();
        @$servicios_gastos->User=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$servicios_gastos->IdUsuario)->first();
        return $servicios_gastos;
    }
    public function Delete($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::table('DbWSE.dbo.ServiciosGastos')->where('IdGasto',$args['IdGasto'])->delete();
        return "Exito";
    }
}
