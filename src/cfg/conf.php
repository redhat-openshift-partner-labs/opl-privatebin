;<?php http_response_code(403); /*
; https://github.com/PrivateBin/PrivateBin/blob/master/cfg/conf.sample.php

[main]
name = "opl-privatebin"
basepath = "https://bin.apps.eng.opdev.io"
discussion = false
opendiscussion = false
password = true
fileupload = false
burnafterreadingselected = true
defaultformatter = "plaintext"
syntaxhighlightingtheme = "sons-of-obsidian"
sizelimit = 1048576
template = "bootstrap"
info = "More information on the <a href='https://labs.apps.eng.opdev.io'>project page</a>."
notice = "Note: This is an unmanaged service: Data may be deleted at anytime."
languageselection = false
languagedefault = "en"
; urlshortener = "https://shortener.example.com/api?link="
qrcode = false
icon = "none"

; Content Security Policy headers allow a website to restrict what sources are
; allowed to be accessed in its context. You need to change this if you added
; custom scripts from third-party domains to your templates, e.g. tracking
; scripts or run your site behind certain DDoS-protection services.
; Check the documentation at https://content-security-policy.com/
; Notes:
; - If you use a bootstrap theme, you can remove the allow-popups from the
;   sandbox restrictions.
; - By default this disallows to load images from third-party servers, e.g. when
;   they are embedded in pastes. If you wish to allow that, you can adjust the
;   policy here. See https://github.com/PrivateBin/PrivateBin/wiki/FAQ#why-does-not-it-load-embedded-images
;   for details.
; - The 'unsafe-eval' is used in two cases; to check if the browser supports
;   async functions and display an error if not and for Chrome to enable
;   webassembly support (used for zlib compression). You can remove it if Chrome
;   doesn't need to be supported and old browsers don't need to be warned.
; cspheader = "default-src 'none'; base-uri 'self'; form-action 'none'; manifest-src 'self'; connect-src * blob:; script-src 'self' 'unsafe-eval' resource:; style-src 'self'; font-src 'self'; img-src 'self' data: blob:; media-src blob:; object-src blob:; sandbox allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"

; stay compatible with PrivateBin Alpha 0.19, less secure
; if enabled will use base64.js version 1.7 instead of 2.1.9 and sha1 instead of
; sha256 in HMAC for the deletion token
zerobincompatibility = false

httpwarning = true
compression = "zlib"

[expire]
default = "1day"

[expire_options]
; Set each one of these to the number of seconds in the expiration period,
; or 0 if it should never expire
5min = 300
10min = 600
1hour = 3600
1day = 86400
1week = 604800
; Well this is not *exactly* one month, it's 30 days:
1month = 2592000
1year = 31536000
never = 0

[formatter_options]
; Set available formatters, their order and their labels
plaintext = "Plain Text"
syntaxhighlighting = "Source Code"
markdown = "Markdown"

[traffic]
; time limit between calls from the same IP address in seconds
; Set this to 0 to disable rate limiting.
limit = 0

; (optional) if your website runs behind a reverse proxy or load balancer,
; set the HTTP header containing the visitors IP address, i.e. X_FORWARDED_FOR
; header = "X_FORWARDED_FOR"

; directory to store the traffic limits in
dir = PATH "data"

[purge]
; minimum time limit between two purgings of expired pastes, it is only
; triggered when pastes are created
; Set this to 0 to run a purge every time a paste is created.
limit = 300

; maximum amount of expired pastes to delete in one purge
; Set this to 0 to disable purging. Set it higher, if you are running a large
; site
batchsize = 10

; directory to store the purge limit in
dir = PATH "data"

[model]
; name of data model class to load and directory for storage
; the default model "Filesystem" stores everything in the filesystem
class = Filesystem
[model_options]
dir = PATH "data"

;[model]
; example of DB configuration for MySQL
;class = Database
;[model_options]
;dsn = "mysql:host=localhost;dbname=privatebin;charset=UTF8"
;tbl = "privatebin_"	; table prefix
;usr = "privatebin"
;pwd = "Z3r0P4ss"
;opt[12] = true	  ; PDO::ATTR_PERSISTENT

;[model]
; example of DB configuration for SQLite
;class = Database
;[model_options]
;dsn = "sqlite:" PATH "data/db.sq3"
;usr = null
;pwd = null
;opt[12] = true	; PDO::ATTR_PERSISTENT
