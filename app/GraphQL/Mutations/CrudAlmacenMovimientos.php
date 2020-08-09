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
            'Detalle'=>$args['Detalle'],
            'IdPlaca'=>$args['IdPlaca'],
        ]);
        @$almacen_movimientos=DB::table('DbWSE.dbo.AlmacenMovimientos')->get()->last();
        foreach ($args['input1'] as $detalle){
            
            DB::table('DbWSE.dbo.AlmacenMovDetalle')->insert([
                'Id'=>@$almacen_movimientos->Id,
                'IdProducto'=>$detalle['IdProducto'],
                'Ingresos'=>@$detalle['Ingresos'],
                'Salidas'=>@$detalle['Salidas'],
            ]);
            $productos=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$detalle['IdProducto'])->first();
            if(isset($detalle['Ingresos'])==true){
                DB::table('DbWSE.dbo.AlmacenProductos')
                ->where('IdProducto',$detalle['IdProducto'])->update([
                    'StockActual'=>(Float)$productos->StockActual+(Float)@$detalle['Ingresos']
                ]);
            }
            else{
                DB::table('DbWSE.dbo.AlmacenProductos')
                ->where('IdProducto',$detalle['IdProducto'])->update([
                    'StockActual'=>(Float)$productos->StockActual-(Float)@$detalle['Salidas']
                ]);
            }
            
            
        }
        @$almacen_movimientos->AlmacenMovDetalle=DB::table('DbWSE.dbo.AlmacenMovDetalle')
                                                ->where('Id',$almacen_movimientos->Id)
                                                ->get();
        foreach(@$almacen_movimientos->AlmacenMovDetalle as $productos){
            $productos->Producto=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$productos->IdProducto)->first();
        }
        @$almacen_movimientos->Placa=DB::table('DbWSE.dbo.Placas')->where('ID',$almacen_movimientos->IdPlaca)->first();
        @$almacen_movimientos->AlmacenMotivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->where('IdMotivo',$almacen_movimientos->IdMotivo)->first();
        return $almacen_movimientos;
    }
    public function Update($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->Update([
            'Fecha'=>$args['Fecha'],
            'Numero'=>$args['Numero'],
            'IdMotivo'=>$args['IdMotivo'],
            'Detalle'=>$args['Detalle'],
            'IdPlaca'=>$args['IdPlaca']
        ]);
        @$almacen_movimientos=DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->first();
        foreach ($args['input1'] as $detalle){
            $alamcen_detalle=DB::table('DbWSE.dbo.AlmacenMovDetalle')->where('Id',$args['Id'])
                            ->where('IdProducto',$detalle['IdProducto'])
                            ->first();
    
            if(isset($alamcen_detalle->Item)==true){
                DB::table('DbWSE.dbo.AlmacenMovDetalle')
                        ->where('Id',$args['Id'])
                        ->where('IdProducto',$detalle['IdProducto'])->update([
                                'Id'=>@$almacen_movimientos->Id,
                                'IdProducto'=>$detalle['IdProducto'],
                                'Ingresos'=>@$detalle['Ingresos'],
                                'Salidas'=>@$detalle['Salidas'],
                ]);
                $productos=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$detalle['IdProducto'])->first();
                if(isset($detalle['Ingresos'])==true){
                    DB::table('DbWSE.dbo.AlmacenProductos')
                    ->where('IdProducto',$detalle['IdProducto'])->update([
                        'StockActual'=>(Float)$productos->StockActual+(Float)@$detalle['Ingresos']
                    ]);
                }
                else{
                    DB::table('DbWSE.dbo.AlmacenProductos')
                    ->where('IdProducto',$detalle['IdProducto'])->update([
                        'StockActual'=>(Float)$productos->StockActual-(Float)@$detalle['Salidas']
                    ]);
                }
            }
            else{
                DB::table('DbWSE.dbo.AlmacenMovDetalle')->insert([
                    'Id'=>@$almacen_movimientos->Id,
                    'IdProducto'=>$detalle['IdProducto'],
                    'Ingresos'=>@$detalle['Ingresos'],
                    'Salidas'=>@$detalle['Salidas'],
                ]);
                $productos=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$detalle['IdProducto'])->first();
                if(isset($detalle['Ingresos'])==true){
                    DB::table('DbWSE.dbo.AlmacenProductos')
                    ->where('IdProducto',$detalle['IdProducto'])->update([
                        'StockActual'=>(Float)$productos->StockActual+(Float)@$detalle['Ingresos']
                    ]);
                }
                else{
                    DB::table('DbWSE.dbo.AlmacenProductos')
                    ->where('IdProducto',$detalle['IdProducto'])->update([
                        'StockActual'=>(Float)$productos->StockActual-(Float)@$detalle['Salidas']
                    ]);
                }
            }
        }

       @$almacen_movimientos->AlmacenMovDetalle=DB::table('DbWSE.dbo.AlmacenMovDetalle')
                                                ->where('Id',$almacen_movimientos->Id)
                                                ->get();
        foreach(@$almacen_movimientos->AlmacenMovDetalle as $productos){
            $productos->Producto=DB::table('DbWSE.dbo.AlmacenProductos')->where('IdProducto',$productos->IdProducto)->first();
        }
        @$almacen_movimientos->Placa=DB::table('DbWSE.dbo.Placas')->where('ID',$almacen_movimientos->IdPlaca)->first();
        @$almacen_movimientos->AlmacenMotivos=DB::table('DbWSE.dbo.vAlmacenMotivos')->where('IdMotivo',$almacen_movimientos->IdMotivo)->first();
        return $almacen_movimientos;
    }
    public function Delete($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::table('DbWSE.dbo.AlmacenMovimientos')->where('Id',$args['Id'])->delete();
        return "Exito";
    }
}
