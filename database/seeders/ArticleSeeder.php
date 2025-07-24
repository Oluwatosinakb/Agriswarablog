<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::truncate(); // Clear old records

        // Get the first category or create one
        $category = Category::first() ?? Category::create([
            'name' => 'Gardening Tips',
            'slug' => 'gardening-tips',
        ]);

        $articles = [
            [
                'title' => 'Achieving High Productivity from Your Own Home Garden.',
                'slug' => Str::slug('Achieving High Productivity from Your Own Home Garden.'),
                'body' => 'Creating a highly productive home garden requires careful planning, proper soil preparation, and consistent maintenance. Whether you\'re a beginner gardener or looking to improve your existing garden\'s yield, this comprehensive guide will help you achieve satisfactory results from plants grown in your home.

## Getting Started with Soil Preparation

The foundation of any successful garden begins with healthy soil. Test your soil\'s pH levels and nutrient content before planting. Most vegetables thrive in slightly acidic to neutral soil with a pH between 6.0 and 7.0.

Add organic compost to improve soil structure and fertility. Well-composted organic matter helps retain moisture while providing essential nutrients that plants need throughout their growing season.

## Choosing the Right Plants

Select varieties that are well-suited to your local climate and growing conditions. Consider factors such as:

- Average temperatures in your area
- Amount of sunlight your garden receives
- Length of your growing season
- Available space for each plant type

Start with easy-to-grow vegetables like tomatoes, lettuce, radishes, and herbs if you\'re new to gardening.

## Watering and Maintenance

Consistent watering is crucial for plant health and productivity. Water deeply but less frequently to encourage strong root development. Early morning watering is ideal as it allows plants to absorb moisture before the heat of the day.

Regular weeding prevents competition for nutrients and water. Mulching around plants helps retain soil moisture and suppress weed growth.

## Maximizing Your Harvest

Plan successive plantings of fast-growing crops like lettuce and radishes every 2-3 weeks for a continuous harvest throughout the season.

Practice companion planting by growing complementary plants together. For example, plant basil near tomatoes to improve flavor and repel pests naturally.

Monitor your plants regularly for signs of pests or diseases. Early detection and treatment prevent small problems from becoming major issues that can devastate your harvest.

With dedication and proper techniques, your home garden can provide fresh, nutritious produce while connecting you with the natural growing process. Start small, learn from experience, and gradually expand your garden as your confidence and knowledge grow.',
                'excerpt' => 'A Practical Guide to Achieving Satisfactory Results from Plants Grown in Your Home.',
                'image_path' => 'images/tomatoes.png',
                'category_id' => $category->id,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'The Best Guide to Planting Seeds with Optimal Results.',
                'slug' => Str::slug('The Best Guide to Planting Seeds with Optimal Results.'),
                'body' => 'Successful seed planting is both an art and a science. Understanding the fundamental principles of seed germination and proper planting techniques will dramatically improve your gardening success rate and help you achieve optimal plant growth.

## Understanding Seed Requirements

Different seeds have varying requirements for successful germination. Some need light to sprout, while others prefer darkness. Temperature, moisture, and soil depth all play crucial roles in the germination process.

Before planting, research the specific needs of each seed variety. Check the seed packet for information about:

- Optimal planting depth (usually 2-3 times the seed\'s diameter)
- Soil temperature requirements
- Days to germination
- Spacing between seeds

## Soil Preparation for Seeds

Prepare a fine, well-draining seed bed. Remove rocks, weeds, and large clumps of soil that could impede seed germination. The soil should be loose enough for delicate seedlings to push through easily.

Mix in compost or well-aged manure to provide gentle nutrition. Avoid fresh manure or high-nitrogen fertilizers that can burn tender seedlings.

## Planting Techniques

Create furrows at the appropriate depth using a hoe or your finger. Plant seeds at consistent spacing to prevent overcrowding and competition for resources.

For very small seeds like lettuce or carrots, mix them with sand before planting to achieve more even distribution.

## Watering and Care

Keep the soil consistently moist but not waterlogged during the germination period. Use a fine spray or misting attachment to avoid disturbing the seeds.

Once seedlings emerge, gradually reduce watering frequency but water more deeply to encourage strong root development.

## Timing Your Plantings

Plant seeds at the right time for your climate zone. Cool-season crops like peas and lettuce can be planted earlier in spring, while warm-season crops like tomatoes and peppers should wait until after the last frost.

Consider starting some seeds indoors 4-6 weeks before the last expected frost to get a head start on the growing season.

Success with seed planting comes with practice and observation. Keep records of what works in your garden and adjust your techniques based on results.',
                'excerpt' => 'Effective Strategies and Techniques to Achieve Healthy and Productive Plant Growth.',
                'image_path' => 'images/planting.png',
                'category_id' => $category->id,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Strategies for Caring for Your Garden More Efficiently and Productively.',
                'slug' => Str::slug('Strategies for Caring for Your Garden More Efficiently and Productively.'),
                'body' => 'Efficient garden management allows you to maximize your harvest while minimizing the time and effort required for maintenance. By implementing smart strategies and organizing your garden effectively, you can create a more productive and manageable growing space.

## Garden Layout and Organization

Design your garden with efficiency in mind. Group plants with similar water and nutrient needs together to streamline care routines. Place frequently harvested crops like herbs and salad greens close to your kitchen for easy access.

Create clear pathways between garden beds to make maintenance tasks easier. Raised beds can improve drainage and make planting, weeding, and harvesting more comfortable.

## Mulching for Success

Apply organic mulch around plants to suppress weeds, retain soil moisture, and regulate soil temperature. Good mulching materials include:

- Straw or hay
- Shredded leaves
- Grass clippings (pesticide-free)
- Compost

Maintain a 2-3 inch layer of mulch, keeping it a few inches away from plant stems to prevent pest and disease issues.

## Water Management Systems

Install drip irrigation or soaker hoses to deliver water directly to plant roots while conserving water. These systems can be automated with timers to ensure consistent watering even when you\'re away.

Collect rainwater in barrels for irrigation during dry periods. Position rain barrels under downspouts to capture roof runoff.

## Integrated Pest Management

Encourage beneficial insects by planting flowers like marigolds, nasturtiums, and sunflowers throughout your garden. These natural predators help control harmful pests without chemical interventions.

Regular garden inspection allows for early pest detection and treatment. Remove affected plants promptly to prevent spread of diseases.

## Seasonal Planning

Create a garden calendar that outlines planting, maintenance, and harvest schedules for each crop. This helps you stay organized and ensures you don\'t miss critical timing for various garden tasks.

Plan crop rotations to prevent soil depletion and reduce pest and disease buildup in the soil.

## Storage and Preservation

Set up proper storage systems for harvested produce. Cool, dark areas work well for root vegetables, while herbs can be dried or frozen for later use.

Learn preservation techniques like canning, dehydrating, and freezing to extend the life of your harvest and reduce waste.

Efficient garden management becomes second nature with experience. Start with these fundamental strategies and adapt them to your specific growing conditions and preferences.',
                'excerpt' => 'An approach that improves plant performance and makes garden management easier.',
                'image_path' => 'images/storage.png',
                'category_id' => $category->id,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}