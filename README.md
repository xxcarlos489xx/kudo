## Especificaciones

- PHP v^7.2.5
- Composer v^2.2.0
- Node v^14.19.0
- Pusher

## Time Real Notificacions

![](https://pusher.com/static/pusher-logo-6caad9362077d81cad1cdd631996b73a.svg)
- Create an account in  [Pusher](https://pusher.com/) to obtain access codes.



## Deployment dev

#Docker
`$ docker-compose up`

`$ php artisan migrate`

`$ php artisan db:seed`

`$ composer install`

`$ npm install`

`$ php artisan serve`

- Default server in port 8000
- Default User:
                    
User  | Password
------------- | -------------
admin@kudo.com.pe| password
test@kudo.pe | password

## Compiled modules frontend

### Folder Modules
- app/modules
### Dev

`$ npm run mix dev nameModuleFolder`

### Watch

`$ npm run mix watch nameModuleFolder`

### Prod

`$ npm run mix production nameModuleFolder`


## Testing

`$ php artisan test`