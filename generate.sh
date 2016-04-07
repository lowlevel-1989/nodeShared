rm gh-pages -rf
mkdir gh-pages
cd manage
tar -czvf ../gh-pages/core.tar.gz core
sh core/update.sh > /dev/null
cp update core
mv update ../gh-pages
