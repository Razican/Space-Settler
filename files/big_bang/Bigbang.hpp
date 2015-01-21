#ifndef BIGBANG_H
	#define BIGBANG_H

	#include <cstdint>
	using namespace std;

	class Bigbang
	{
	private:
		uint_fast32_t current_galaxies;
		uint_fast32_t current_stars;

		uint_fast16_t black_holes;
		uint_fast16_t neutron_stars;
		uint_fast16_t quark_stars;
		uint_fast16_t white_dwarfs;
		uint_fast16_t type_o_stars;
		uint_fast16_t type_b_stars;
		uint_fast16_t type_a_stars;
		uint_fast16_t type_f_stars;
		uint_fast32_t type_g_stars;
		uint_fast32_t type_k_stars;
		uint_fast32_t type_m_stars;
		uint_fast32_t planets;
		uint_fast32_t gaseous_planets;
		uint_fast32_t hot_jupiters;
		uint_fast32_t rocky_planets;
		uint_fast32_t super_earths;
		uint_fast32_t asteroid_belts;
		uint_fast32_t moons;
		uint_fast32_t habitable_bodies;

		float min_dist_star;
		float max_dist_star;
		uint_fast64_t min_orbital_period;
		uint_fast64_t max_orbital_period;
		float min_temp;
		float max_temp;

	public:
		Bigbang();
		~Bigbang() = default;

		uint_fast16_t get_black_holes() const {return this->black_holes;}
		uint_fast16_t get_neutron_stars() const {return this->neutron_stars;}
		uint_fast16_t get_quark_stars() const {return this->quark_stars;}
		uint_fast16_t get_white_dwarfs() const {return this->white_dwarfs;}
		uint_fast16_t get_type_o_stars() const {return this->type_o_stars;}
		uint_fast16_t get_type_b_stars() const {return this->type_b_stars;}
		uint_fast16_t get_type_a_stars() const {return this->type_a_stars;}
		uint_fast16_t get_type_f_stars() const {return this->type_f_stars;}
		uint_fast32_t get_type_g_stars() const {return this->type_g_stars;}
		uint_fast32_t get_type_k_stars() const {return this->type_k_stars;}
		uint_fast32_t get_type_m_stars() const {return this->type_m_stars;}
		uint_fast32_t get_planets() const {return this->planets;}
		uint_fast32_t get_gaseous_planets() const {return this->gaseous_planets;}
		uint_fast32_t get_hot_jupiters() const {return this->hot_jupiters;}
		uint_fast32_t get_rocky_planets() const {return this->rocky_planets;}
		uint_fast32_t get_super_earths() const {return this->super_earths;}
		uint_fast32_t get_asteroid_belts() const {return this->asteroid_belts;}
		uint_fast32_t get_moons() const {return this->moons;}
		uint_fast32_t get_habitable_bodies() const {return this->habitable_bodies;}

		float get_min_dist_star() const {return this->min_dist_star;}
		float get_max_dist_star() const {return this->max_dist_star;}
		uint_fast64_t get_min_orbital_period() const {return this->min_orbital_period;}
		uint_fast64_t get_max_orbital_period() const {return this->max_orbital_period;}
		float get_min_temp() const {return this->min_temp;}
		float get_max_temp() const {return this->max_temp;}

		bool create_galaxy(int solar_systems);
	};

#endif