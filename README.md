# groupoffice-yubico
Group Office module to enable strong two-factor authentication

## Prerequisites

- Configured Yubikey with OTP
- Yubikey prefix
- Secret Key and Client ID - https://upgrade.yubico.com/getapikey/

After module install you have to insert key, prefix and client id into go_users table. 
All information are unreadable for common user so as an db administrator you have to update them manually.
Prefix is stored for stronger security. When someone reconfigure your key with new public identity 
you have to change this prefix also in database.