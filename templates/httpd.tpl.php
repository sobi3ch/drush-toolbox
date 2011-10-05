<?php
/**
 * This is the default httpd.conf template for Drush Server running on Mac OSX
 * using the builtin Apache and PHP.
 *
 * Available Variables:
 * - host
 * - port
 * - uri
 * - conf_path
 * - base_path
 * - log_path
 * - doc_root
 */
?>
#
# Generated by drush-server.
#
ServerRoot /usr

#
# Required modules
#
LoadModule authz_host_module libexec/apache2/mod_authz_host.so
LoadModule dir_module libexec/apache2/mod_dir.so
LoadModule mime_module libexec/apache2/mod_mime.so
LoadModule log_config_module libexec/apache2/mod_log_config.so
LoadModule rewrite_module libexec/apache2/mod_rewrite.so
LoadModule php5_module libexec/apache2/libphp5.so
LoadModule status_module libexec/apache2/mod_status.so

<IfModule php5_module>
  AddType application/x-httpd-php .php
  AddType application/x-httpd-php-source .phps
  <IfModule dir_module>
    DirectoryIndex index.html index.php
  </IfModule>
</IfModule>

ExtendedStatus On
<Location /server-status>
  # Turn of rewrite rules or else Drupal's .htaccess rewrite rules will clobber
  # this location.
  RewriteEngine off
  SetHandler server-status
  Order Deny,Allow
  Allow from all
</Location>

#
# Custom configuration built by drush
#
PidFile <?php print $conf_path; ?>/httpd.pid
LockFile <?php print $conf_path; ?>/accept.lock

ServerName <?php print $host; ?>

<?php foreach ($ports as $port): ?>
Listen <?php print $port ."\n"; // Save me from the line-break monster! ?>
<?php endforeach; ?>

ErrorLog <?php print $log_path; ?>/error_log
LogFormat "%h %l %u %t \"%r\" %>s %b" common
CustomLog <?php print $log_path; ?>/access_log common

#
# Use name-based virtual hosting.
#
<?php foreach ($ports as $port): ?>
NameVirtualHost *:<?php print $port ."\n"; // Save me from the line-break monster! ?>
<?php endforeach; ?>

Include <?php print $conf_path; ?>/sites/*.conf
