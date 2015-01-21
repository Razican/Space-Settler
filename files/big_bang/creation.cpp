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

		cout << "\t" << solar_systems << " solar systems:" << endl;
		cout << "\t\tBlack holes: " << 0 << endl;
		cout << "\t\tNeutron stars: " << 0 << endl;
		cout << "\t\tQuark stars: " << 0 << endl;
		cout << "\t\tWhite dwarfs: " << 0 << endl;
		cout << "\t\tType O stars: " << 0 << endl;
		cout << "\t\tType B stars: " << 0 << endl;
		cout << "\t\tType A stars: " << 0 << endl;
		cout << "\t\tType F stars: " << 0 << endl;
		cout << "\t\tType G stars: " << 0 << endl;
		cout << "\t\tType K stars: " << 0 << endl;
		cout << "\t\tType M stars: " << 0 << endl << endl;

		cout << "\tAsteroid belts: " << 0 << endl << endl;

		cout << "\t" << 0 << " planets: " << endl;
		cout << "\t\tGaseous planets: " << 0 << endl;
		cout << "\t\t\tHot Jupiters: " << 0 << endl;
		cout << "\t\tRocky planets: " << 0 << endl;
		cout << "\t\t\tSuper-Earths: " << 0 << endl << endl;

		cout << "\tMoons: " << 0 << endl << endl;

		cout << "\tTotal habitable bodies:  " << 0 << endl << endl;

		cout << "Records:" << endl;
		cout << "\tMinimum distance to star: " << 0 << " AU" << endl;
		cout << "\tMaxium distance to star: " << 0 << " AU" << endl;
		cout << "\tMinimum orbital period: " << 0 << " hours" << endl;
		cout << "\tMaximum orbital period: " << 0 << " years" << endl;
		cout << "\tMinimum temperature: " << 0 << " K" << endl;
		cout << "\tMaximum temperature: " << 0 << " K" << endl << endl;

		cout << "Total creation time: " << (end_time - start_time)/1e+9f << " seconds." << endl << endl;
	}
	else
	{
		cout << "An error occurred when creating the galaxy." << endl << endl;
	}


/*	string msg = "Testing backspace...";
	cout << msg;

	this_thread::sleep_for(chrono::seconds(5));

	cout << '\r';
	cout << string(msg.length(),' ');
	cout << '\r';

	cout << "Success!!" << endl;*/

	system("stty echo");
	return 0;
}