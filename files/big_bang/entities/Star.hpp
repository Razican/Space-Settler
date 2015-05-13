#ifndef STAR_H
	#define STAR_H

	class Star
	{
	private:
		uint_fast32_t star_id
	public:
		Star(uint_fast32_t current_stars, uint_fast32_t current_galaxies);
		~Star();
	};
#endif