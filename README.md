#### Google analytics will track the following events:
1. From client side:
- Visit products list page
- Visit products details page
- Add product to the cart on list page

2. From server side:
- Purchase single product from details page
- Purchase multiple products from list page

#### Once you have Docker and Docker Compose installed, you can get this project up and running with:

```
make setup
```

To stop the project:
```
make down
```

#### Environment:
1. You can provide values for your own GA4 property in GA_MEASUREMENT_ID and GA_MEASUREMENT_API_SECRET in .env
2. In case of conflicting ports, edit HOST_DB_PORT and/or HOST_NGINX_PORT in .env
