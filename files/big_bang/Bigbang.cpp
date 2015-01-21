#include "Bigbang.hpp"
#include <sys/ioctl.h>
#include <iostream>

Bigbang::Bigbang()
{
	this->current_galaxies = 0; // TODO real count
	this->current_stars = 0; // TODO real count

	this->black_holes = this->neutron_stars = this->quark_stars =
	this->white_dwarfs = this->type_o_stars = this->type_b_stars =
	this->type_a_stars = this->type_f_stars = this->type_g_stars =
	this->type_k_stars = this->type_m_stars = this->planets =
	this->gaseous_planets = this->hot_jupiters = this->rocky_planets =
	this->super_earths = this->asteroid_belts = this->moons = this->habitable_bodies = 0;

	this->min_dist_star = this->max_dist_star = this->min_orbital_period =
	this->max_orbital_period = this->min_temp = this->max_temp = 0;
}

bool Bigbang::create_galaxy(int solar_systems)
{
	winsize console;
	ioctl(0, TIOCGWINSZ, &console);
	int columns = console.ws_col;

	cout << '[' << string(columns-8, ' ') << "]   0%\r";

	for (int i = 1; i <= solar_systems; i++)
	{
		// Star Creation
		//Star star(this->current_star, this->current_galaxies);
		// update stats for star
	}

	cout << endl;
	return true;
}