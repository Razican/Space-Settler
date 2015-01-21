#include <iostream>
#include <iomanip>
#include <chrono>
#include <random>
#include <stdexcept>
#include <locale>
#include "Bigbang.hpp"
using namespace std;

int main(int argc, char *argv[])
{
	system("stty -echo");

	locale loc;
	try
	{
		loc = locale("en_GB.UTF8");
	}
	catch (runtime_error)
	{
		loc = locale(loc, "", locale::ctype);
	}

	locale::global(loc);
	cout.imbue(locale());

	auto start_time = chrono::system_clock::now().time_since_epoch().count();

	mt19937 mt_rand{(uint_fast32_t) start_time};
	uniform_int_distribution<int> galaxy_systems(95000, 105000);
	int solar_systems = galaxy_systems(mt_rand);

	cout << endl << "Beginning the creation of the galaxy. It will contain " << solar_systems << " solar systems." << endl << endl;

	Bigbang bigbang;
	if (bigbang.create_galaxy(solar_systems))
	{
		auto end_time = chrono::system_clock::now().time_since_epoch().count();

		cout << "Galaxy was successfully created." << endl << endl;

		cout << "Data:" << endl << endl;

		cout << "   " << solar_systems << " solar systems:" << endl;
		cout << "      Black holes: " << bigbang.get_black_holes() << endl;
		cout << "      Neutron stars: " << bigbang.get_neutron_stars() << endl;
		cout << "      Quark stars: " << bigbang.get_quark_stars() << endl;
		cout << "      White dwarfs: " << bigbang.get_white_dwarfs() << endl;
		cout << "      Type O stars: " << bigbang.get_type_o_stars() << endl;
		cout << "      Type B stars: " << bigbang.get_type_b_stars() << endl;
		cout << "      Type A stars: " << bigbang.get_type_a_stars() << endl;
		cout << "      Type F stars: " << bigbang.get_type_f_stars() << endl;
		cout << "      Type G stars: " << bigbang.get_type_g_stars() << endl;
		cout << "      Type K stars: " << bigbang.get_type_k_stars() << endl;
		cout << "      Type M stars: " << bigbang.get_type_m_stars() << endl << endl;

		cout << "   Asteroid belts: " << bigbang.get_asteroid_belts() << endl << endl;

		cout << "   " << (bigbang.get_gaseous_planets()+bigbang.get_rocky_planets()) << " planets: " << endl;
		cout << "      Gaseous planets: " << bigbang.get_gaseous_planets() << endl;
		cout << "         Hot Jupiters: " << bigbang.get_hot_jupiters() << endl;
		cout << "      Rocky planets: " << bigbang.get_rocky_planets() << endl;
		cout << "         Super-Earths: " << bigbang.get_super_earths() << endl << endl;

		cout << "   Moons: " << bigbang.get_moons() << endl << endl;

		cout << "   Total habitable bodies:  " << bigbang.get_habitable_bodies() << endl << endl;

		cout << "Records:" << endl;
		cout << "   Minimum distance to star: " << bigbang.get_min_dist_star() << " AU" << endl;
		cout << "   Maxium distance to star: " << bigbang.get_max_dist_star() << " AU" << endl;
		cout << "   Minimum orbital period: " << (bigbang.get_min_orbital_period()/3600.0) << " hours" << endl;
		cout << "   Maximum orbital period: " << (bigbang.get_max_orbital_period()/31536000.0) << " years" << endl;
		cout << "   Minimum temperature: " << bigbang.get_min_temp() << " K" << endl;
		cout << "   Maximum temperature: " << bigbang.get_max_temp() << " K" << endl << endl;

		cout << "Total creation time: " << (end_time - start_time)/1e+9f << " seconds." << endl << endl;
	}
	else
	{
		cout << "An error occurred when creating the galaxy." << endl << endl;
	}

	system("stty echo");
	return 0;
}