## Elasticsearch with Laravel

This simple project using elasticsearch with laravel, implementing searching
with elastic's basic query operators like `bool`, `filter` etc.

### Stack & Packages overview:
- Laravel with Breeze Starter Kit
- Laravel Sail
- Elastic search PHP Package

### Running the Project:
- Download the [News Headlines Dataset](https://www.kaggle.com/datasets/rmisra/news-category-dataset/)
- Replace `headlines_data.json` with downloaded dataset in json format
- Clone and cd into project dir and run `sail up` in terminal
- Open new terminal in project directory and run
    - `sail artisan migrate`
    - `sail artisan db:seed`
    - `sail artisan search:reindex` to index all headlines to Elasticsearch
- Open new terminal with same directory and run `npm run dev`
- Project will be running on `http://127.0.0.1`
- Search Page: `http://127.0.0.1/headline`

### References:
- **[Integrate Elastic into Laravel](https://madewithlove.com/blog/how-to-integrate-elasticsearch-in-your-laravel-app-2022/)**
- **[Integrate Elastic into Laravel](https://madewithlove.com/blog/how-to-integrate-your-laravel-app-with-elasticsearch/)**
- **[Elastic Search Learning](https://github.com/LisaHJung/Beginners-Crash-Course-to-Elastic-Stack-Series-Table-of-Contents?tab=readme-ov-file)**
