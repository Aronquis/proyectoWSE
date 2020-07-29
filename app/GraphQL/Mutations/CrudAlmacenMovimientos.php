<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
class CrudAlmacenMovimientos
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
        // TODO implement the resolver
        DB::table('DbWSE.dbo.AlmacenMovimientos')->insert([

            'Fecha'=>$args['Fecha'],
            'Numero'=>$args['Numero'],
            'IdMotivo'=>$args['IdMotivo'],
            'IdProducto'=>$args['IdProducto'],
            'Ingresos'=>$args['Ingresos'],
            'Salidas'=>$args['Salidas'],
            'Detalle'=>$args['Detalle'],
            'IdPlaca'=>$args['IdPlaca']
        ]);
        @$almacen_movimientos=DB::table('DbWSE.dbo.AlmacenMovimientos')->get()->last();
        @$almacen_movimientos->Producto=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$almacen_movimientos->IdProducto)->first();
        @$almacen_movimientos->Placa=DB::table('DbWSE.dbo.Placas')->where('ID',$almacen_movimientos->IdPlaca)->first();
        @$almacen_movimientos->AlmacenMotivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->where('IdMotivo',$almacen_movimientos->IdMotivo)->first();
        return $almacen_movimientos;
    }
    public function Update($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if($args['IdMotivo']!=""){
            DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->Update([
                'IdMotivo'=>$args['IdMotivo'],
            ]);
        }
        else{
            DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->Update([
                'Fecha'=>$args['Fecha'],
                'Numero'=>$args['Numero'],
                'IdMotivo'=>$args['IdMotivo'],
                'IdProducto'=>$args['IdProducto'],
                'Ingresos'=>$args['Ingresos'],
                'Salidas'=>$args['Salidas'],
                'Detalle'=>$args['Detalle'],
                'IdPlaca'=>$args['IdPlaca']
            ]);
        }
        
        @$almacen_movimientos=DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->first();
        @$almacen_movimientos->Producto=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$almacen_movimientos->IdProducto)->first();
        @$almacen_movimientos->Placa=DB::table('DbWSE.dbo.Placas')->where('ID',$almacen_movimientos->IdPlaca)->first();
        @$almacen_movimientos->AlmacenMotivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->where('IdMotivo',$almacen_movimientos->IdMotivo)->first();
        return $almacen_movimientos;
    }
    public function Delete($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->delete();
    }
}
