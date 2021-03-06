#!/usr/bin/env bash
#
# Script run BEFORE kmom specific scripts.
# Put tests here that applies to all kmoms.
#
# Available (and usable) data:
#   $COURSE
#   $KMOM
#   $ACRONYM
#   $REDOVISA_HTTP_PREFIX
#   $REDOVISA_HTTP_POSTFIX
#   eval "$BROWSER" "$url" &
#
printf ">>> -------------- Pre (all kmoms) ----------------------\n"

# # Open localhost:1337 in browser
# printf "Open localhost:1337/eshop/index in browser\n"
# eval "$BROWSER" "http://127.0.0.1:1337/eshop/index" &

# Open me/redovisa
url="$REDOVISA_HTTP_PREFIX/~$ACRONYM/dbwebb-kurser/$COURSE/$REDOVISA_HTTP_POSTFIX/htdocs"
printf "$url\n" 2>&1
eval "$BROWSER" "$url" &

# Open github
url=$( cat me/redovisa/github.txt )
printf "$url/commits/master\n" 2>&1
eval "$BROWSER" "$url/commits/master" &

# Do different things depending on kmom
case $KMOM in
    kmom01)
        url="$REDOVISA_HTTP_PREFIX/~$ACRONYM/dbwebb-kurser/$COURSE/me/kmom01/guess"
        printf "$url\n" 2>&1
        eval "$BROWSER" "$url" &
    ;;
    kmom03 | \
    kmom04)
        url="$DIR/me/redovisa/build/coverage/index.html"
        printf "$url\n" 2>&1
        eval "$BROWSER" "$url" &
    ;;
    kmom10)
        url="$DIR/me/kmom10/proj/build/coverage/index.html"
        printf "$url\n" 2>&1
        eval "$BROWSER" "$url" &

        url="$REDOVISA_HTTP_PREFIX/~$ACRONYM/dbwebb-kurser/$COURSE/me/kmom10/proj/htdocs"
        printf "$url\n" 2>&1
        eval "$BROWSER" "$url" &
    ;;
esac

echo
