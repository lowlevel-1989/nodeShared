rm gh-pages -rf
mkdir gh-pages
cd manage
sh core/update.sh > /dev/null
cp update core
mv update ../gh-pages
tar -czvf ../gh-pages/core.tar.gz core
