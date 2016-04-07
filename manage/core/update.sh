UPDATE=$1
if [ "$UPDATE" = 'core' ]; then
  echo 'update core'
  wget hhttps://formatcom.github.io/nodeShared/core.tar.gz --no-check-certificate
  tar -xzvf core.tar.gz
  rm -f core.tar.gz
else
  echo 'new version update'
  date +%s > update
fi
