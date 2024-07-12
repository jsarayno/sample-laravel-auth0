# Testing Auth0 with Laravel

## Reference

Following the tutorial from Auth0 https://auth0.com/docs/quickstart/webapp/laravel

## SDK Configuration
Run the following command from your project directory to download the Auth0 CLI:
```
curl -sSfL https://raw.githubusercontent.com/auth0/auth0-cli/main/install.sh | sh -s -- -b .
```

Then authenticate the CLI with your Auth0 account, choosing "as a user" when prompted:
```
./auth0 login
```

Next, create a new application with Auth0:

```
./auth0 apps create \
  --name "My Laravel Application" \
  --type "regular" \
  --auth-method "post" \
  --callbacks "http://localhost:8000/callback" \
  --logout-urls "http://localhost:8000" \
  --reveal-secrets \
  --no-input \
  --json > .auth0.app.json
```

You should also create a new API:

```
./auth0 apis create \
  --name "My Laravel Application's API" \
  --identifier "https://github.com/auth0/laravel-auth0" \
  --offline-access \
  --no-input \
  --json > .auth0.api.json
```

This produces two files in your project directory that configure the SDK.

```
As these files contain credentials it's important to treat these as sensitive. You should ensure you do not commit these to version control. If you're using Git, you should add them to your .gitignore file:

echo ".auth0.*.json" >> .gitignore
```
