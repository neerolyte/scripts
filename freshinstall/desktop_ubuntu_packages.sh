#!/bin/bash 

pkgs=(
	vim{,-gnome}
	unison-gtk
	gimp
	gnome-do{,-plugins}
	emacs23
	keepassx
	pidgin
	git-core
	openjdk-6-jre
	#icedtea6-plugin -- worst fucking java plugin ever!
	deluge{,d}
	thunderbird
	clusterssh
	vlc
	flashplugin-installer
	compizconfig-settings-manager
)

if [[ $(uname -m) = x86_64 ]]; then
	pkgs+=(ia32-libs)
fi


sudo -- apt-get install -- "${pkgs[@]}"

sudo -- apt-get purge icedtea6-plugin

echo "Don't forget chrome..."
