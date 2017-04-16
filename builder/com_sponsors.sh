#!/usr/bin/env bash

BUILDER=`pwd`
JOOMLA=`cd .. && pwd`

EXT_TYPE="com"
EXT_NAME="sponsors"
EXTENSION=$EXT_TYPE"_"$EXT_NAME

echo "**********************"
echo "Building: "$EXTENSION
echo "**********************"
echo "Joomla:" $JOOMLA
echo "Builder:" $BUILDER
echo "**********************"

echo "Cleaning..."
cd $BUILDER
rm -rf $BUILDER/tmp/
rm -rf $BUILDER/$EXTENSION.zip

echo "Creating Directory Structure..."
mkdir -p $BUILDER/tmp/
mkdir -p $BUILDER/tmp/$EXTENSION/admin
mkdir -p $BUILDER/tmp/$EXTENSION/admin/language/en-GB/
mkdir -p $BUILDER/tmp/$EXTENSION/admin/language/es-ES/
mkdir -p $BUILDER/tmp/$EXTENSION/site
mkdir -p $BUILDER/tmp/$EXTENSION/site/language/en-GB/
mkdir -p $BUILDER/tmp/$EXTENSION/site/language/es-ES/
mkdir -p $BUILDER/tmp/$EXTENSION/media

echo "Copying Admin Files..."
cp -r $JOOMLA/administrator/components/$EXTENSION/* $BUILDER/tmp/$EXTENSION/admin/
find $JOOMLA/administrator/language/en-GB/ -name "*$EXTENSION*.ini" -exec cp {} $BUILDER/tmp/$EXTENSION/site/language/en-GB/ \;
find $JOOMLA/administrator/language/es-ES/ -name "*$EXTENSION*.ini" -exec cp {} $BUILDER/tmp/$EXTENSION/site/language/es-ES/ \;

echo "Copying Site Files..."
cp -r $JOOMLA/components/$EXTENSION/* $BUILDER/tmp/$EXTENSION/site/
find $JOOMLA/language/en-GB/ -name "*$EXTENSION*.ini" -exec cp {} $BUILDER/tmp/$EXTENSION/admin/language/en-GB/ \;
find $JOOMLA/language/es-ES/ -name "*$EXTENSION*.ini" -exec cp {} $BUILDER/tmp/$EXTENSION/admin/language/es-ES/ \;

echo "Copying Media Files..."
cp -r $JOOMLA/media/$EXTENSION/* $BUILDER/tmp/$EXTENSION/media/

echo "Copying Manifest file..."
mv $BUILDER/tmp/$EXTENSION/admin/$EXT_NAME.xml  $BUILDER/tmp/$EXTENSION/

echo "Building zip package..."
cd $BUILDER/tmp/$EXTENSION && zip -r $BUILDER/$EXTENSION.zip ./

echo "Done!"