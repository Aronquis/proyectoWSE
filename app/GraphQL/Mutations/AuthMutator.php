<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\JWTServices;
use Firebase\JWT\JWT;
use JWTAuth;
class AuthMutator
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
    public function Login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
        $usuario=DB::table('DbWSE.dbo.Usuarios')->where('IdUsuario',$args['IdUsuario'])->first();
        if($usuario->Password==$args['Password']){
            $payload = array(
                "iss" => $usuario->Password,
                "aud" => $usuario->NmUsuario,
                "iat" => $usuario->IdPerfil,
                "nbf" => $usuario->IdChofer
            );
            $usuario->token = JWT::encode($payload, '');
            return $usuario;
        }
        else{
            return $usuario=null;
        }
    }
}
