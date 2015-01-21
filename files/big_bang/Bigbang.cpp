#include "Bigbang.hpp"

Bigbang::Bigbang()
{
	this->current_galaxies = 0; // TODO real count
	this->current_stars = 0; // TODO real count

	this->black_holes = this->neutron_stars = this->quark_stars =
	this->white_dwarfs = this->typeo_stars = this->typeb_stars =
	this->typea_stars = this->typef_stars = this->typeg_stars =
	this->typek_stars = this->typem_stars = this->planets =
	this->gaseous_planets = this->hot_jupiters = this->rocky_planets =
	this->super_earths = this->asteroid_belts = this->moons = this->habitable_bodies = 0;

	this->min_dist_star = this->max_dist_star = this->min_orbital_period =
	this->max_orbital_period = this->min_temp = this->max_temp = 0;
}

bool Bigbang::create_galaxy(int solar_systems)
{
	// TODO
	return true;
}