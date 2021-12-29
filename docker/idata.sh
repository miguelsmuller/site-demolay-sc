#!/usr/bin/env sh

echo "== About Cli =="
wp cli info --allow-root > /dev/null 2>&1

echo "== Install WordPress =="
wp config set table_prefix ${WORDPRESS_TABLE_PREFIX} --allow-root

wp core install \
  --path="/var/www/html" \
  --skip-plugins --skip-themes \
  --url="http://localhost:${WORDPRESS_PORT}" \
  --title="-" \
  --admin_user=${WORDPRESS_ADMIN_USER} \
  --admin_password=${WORDPRESS_ADMIN_PASSWORD} \
  --admin_email=${WORDPRESS_ADMIN_EMAIL} \
  --skip-email \
  --allow-root

echo "== Import =="
tar -xf /docker/data/media.tgz -C ./
gzip -c -d /docker/data/database.sql.gz | wp db import --allow-root -


echo "== Options =="
wp option update permalink_structure "${WORDPRESS_PERMALINK_STRUCTURE}" --skip-themes --skip-plugins --allow-root
wp option update siteurl "http://127.0.0.1:${WORDPRESS_PORT}" --allow-root
wp option update home "http://127.0.0.1:${WORDPRESS_PORT}" --allow-root


echo "== Plugins ans Theme =="
wp theme delete $(wp theme list --fields=name --status=inactive --allow-root) --allow-root
wp plugin install akismet --version=4.0.7 --force --allow-root
wp plugin install better-wp-security --version=6.2.0 --force --allow-root
wp plugin install contact-form-7 --version=4.2 --force --allow-root
wp plugin install post-type-archive-links --version=1.3.1 --force --allow-root
wp plugin install wp-clean-up --version=1.2.3 --force --allow-root
wp plugin install wp-mail-smtp --version=1.2.5 --force --allow-root
wp plugin install wpMandrill --version=1.33 --force --allow-root
wp plugin install wp-migrate-db --version=1.0.2 --force --allow-root
wp plugin install wp-sitemap-page --force --allow-root
wp plugin install wp-smushit --version=2.7 --force --allow-root

echo "== User List =="
wp user list --allow-root

echo "== Theme List =="
wp theme list --allow-root

echo "== Plugin List =="
wp plugin list --allow-root

echo "== Done! =="
