<?php
namespace Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthMiddleware implements IMiddleware {

    public function handle(Request $request): void
    {
    	if ( ! ( $auth = get_wpauth() ) ) {
    		redirect(url());
    	}
    	if ( $auth->check() ) {
    		if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) {
    			redirect(redirect_by_role('admin'));
    		}
    		if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) {
    			redirect(redirect_by_role('author'));
    		}
    	}
    }
}