#!/usr/bin/env bash

joomla=`pwd`
ext_name="com_sponsors"
version=`cat VERSION`

echo "**********************"
echo "Building: "$ext_name
echo "Version: "$version
echo "**********************"
echo "Path: "$joomla
echo "**********************"

echo "Cleaning..."
rm -rf $joomla/_builds
mkdir -p $joomla/_builds $joomla/_builds/$ext_name

echo "Creating Directory Structure..."
mkdir -p $joomla/_builds/
mkdir -p $joomla/_builds/$ext_name/site
mkdir -p $joomla/_builds/$ext_name/media
mkdir -p $joomla/_builds/$ext_name/administrator
mkdir -p $joomla/_builds/$ext_name/languages/site/en-GB
mkdir -p $joomla/_builds/$ext_name/languages/site/es-ES
mkdir -p $joomla/_builds/$ext_name/languages/administrator/en-GB
mkdir -p $joomla/_builds/$ext_name/languages/administrator/es-ES

echo "Copying Admin Files..."
cp -r $joomla/administrator/components/$ext_name/* $joomla/_builds/$ext_name/administrator/

find $joomla/administrator/language/en-GB/ -name "*$ext_name*.ini" -exec cp {} $joomla/_builds/$ext_name/languages/administrator/en-GB/ \;
find $joomla/administrator/language/es-ES/ -name "*$ext_name*.ini" -exec cp {} $joomla/_builds/$ext_name/languages/administrator/es-ES/ \;

echo "Copying Site Files..."
cp -r $joomla/components/$ext_name/* $joomla/_builds/$ext_name/site/

find $joomla/language/en-GB/ -name "*$ext_name*.ini" -exec cp {} $joomla/_builds/$ext_name/languages/site/en-GB/ \;
find $joomla/language/es-ES/ -name "*$ext_name*.ini" -exec cp {} $joomla/_builds/$ext_name/languages/site/es-ES/ \;

echo "Copying Media Files..."
cp -r $joomla/media/$ext_name/* $joomla/_builds/$ext_name/media/

echo "Copying Manifest file..."
mv $joomla/_builds/$ext_name/administrator/${ext_name/com_//}.xml  $joomla/_builds/$ext_name/

perl -pi -e 's/VERSION/'$version'/g' $joomla/_builds/$ext_name/${ext_name/com_//}.xml

echo "Building zip package..."
cd $joomla/_builds/$ext_name && zip -r $joomla/_builds/$ext_name.zip ./

echo "Done!"