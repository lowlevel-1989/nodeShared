rm gh-pages -rf
mkdir gh-pages
cd manage
sh nodeShared/update.sh > /dev/null
cp update nodeShared
mv update ../gh-pages
tar -czvf ../gh-pages/core.tar.gz nodeShared
