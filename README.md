# SynologyCloudflareDDNS

# Install
1. SSH into your NAS
2. run as root
```code
sudo -i
```
3. Download cloudflareddns.php to /usr/syno/bin/ddns/cloudflareddns.php

```code
wget https://raw.githubusercontent.com/Freedomlover/SynologyCloudflareDDNS/main/cloudflareddns.php -O /usr/syno/bin/ddns/cloudflareddns.php
chmod +x /usr/syno/bin/ddns/cloudflareddns.php
```

4. Edit /etc.defaults/ddns_provider.conf
```code
vi /etc.defaults/ddns_provider.conf
```
Add content to last line

```code
[Cloudflare DDNS]
        modulepath=/usr/syno/bin/ddns/cloudflareddns.php
        queryurl=https://www.cloudflare.com
        website=https://www.cloudflare.com
```
or
```code
echo "[Cloudflare DDNS]">>/etc.defaults/ddns_provider.conf
echo "        modulepath=/usr/syno/bin/ddns/cloudflareddns.php">>/etc.defaults/ddns_provider.conf
echo "        queryurl=https://www.cloudflare.com">>/etc.defaults/ddns_provider.conf
echo "        website=https://www.cloudflare.com">>/etc.defaults/ddns_provider.conf
```

# Get Cloudflare parameters
1. Copy your zone ID from domain overvice page
2. Go to My Profile -> API Tokens -> Create Token Use Edit zone DNS template.  Should have the permissions of Zone > DNS > Edit  and Zone Resources Include > Specific zone > Your domain. Copy the api token.

# Setup DDNS on your DSM
1. Go to Control Panel -> External Access -> DDNS -> Add
2. Enter the following
   - <b>Service provider:</b> Cloudflare DDNS
   - <b>Hostname:</b> dsm.domain.com
   - <b>Username/Email:</b> Zone ID
   - <b>Password/Key:</b> API Token
