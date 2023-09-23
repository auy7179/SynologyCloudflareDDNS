# SynologyCloudflareDDNS

wget https://raw.githubusercontent.com/Freedomlover/SynologyCloudflareDDNS/main/cloudflareddns.php -O /usr/syno/bin/ddns/cloudflareddns.php
chmod +x /usr/syno/bin/ddns/cloudflareddns.php


vi /etc.defaults/ddns_provider.conf

add

[Cloudflare DDNS]
        modulepath=/usr/syno/bin/ddns/cloudflareddns.php
        queryurl=https://www.cloudflare.com
        website=https://www.cloudflare.com
