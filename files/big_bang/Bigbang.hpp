#ifndef BIGBANG_H
	#define BIGBANG_H

	#include <cstdint>
	#include <iomanip>
	#include <iostream>

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
		uint_fast16_t typeo_stars;
		uint_fast16_t typeb_stars;
		uint_fast16_t typea_stars;
		uint_fast16_t typef_stars;
		uint_fast32_t typeg_stars;
		uint_fast32_t typek_stars;
		uint_fast32_t typem_stars;
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
		float min_orbital_period;
		float max_orbital_period;
		float min_temp;
		float max_temp;

	public:
		Bigbang();
		~Bigbang() = default;

		bool create_galaxy(int solar_systems);
	};

	static inline void load_bar(unsigned int x, unsigned int n, unsigned int w = 50)
	{
		if ((x != n) && (x%(n/100+1) != 0)) return;

		float ratio =  x/(float)n;
		int c = ratio*w;

		cout << setw(3) << (int)(ratio*100) << "% [";
		for (int x=0; x<c; x++) cout << "=";
		for (int x=c; x<w; x++) cout << " ";
		cout << "]\r" << flush;
	}

#endif