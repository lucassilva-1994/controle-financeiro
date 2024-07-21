import { Routes } from "@angular/router";
import { AuthComponent } from "./auth.component";

export const AUTH_ROUTES: Routes = [
    {
        path: '',
        component: AuthComponent,
        title: 'Entrar',
        data: {
            authMode: 'signIn'
        }
    },
    {
        path: 'sign-up',
        component: AuthComponent,
        title: 'Novo usuário',
        data: {
            authMode: 'signUp'
        }
    },
    {
        path: 'forgot-password',
        component: AuthComponent,
        title: 'Recuperar senha',
        data: {
            authMode: 'forgotPassword'
        }
    },
    {
        path: 'activate-account/:email/:token',
        component: AuthComponent,
        title: 'Ativar conta',
        data: {
            authMode: 'activateAccount'
        }
    }
];