<?php

class LinkCard
{
    private string $url;
    private string $keyword;
    private string $title;
    private string $description;
    private string $imageUrl;

    public function __construct(
        string $url,
        string $keyword,
        string $title = '',
        string $description = '',
        string $imageUrl = ''
    ) {
        $this->url = $url;
        $this->keyword = $keyword;
        $this->title = $title ?: $keyword . ' - 官方平台';
        $this->description = $description ?: '欢迎访问 ' . $keyword . ' 官方网站，体验精彩体育赛事。';
        $this->imageUrl = $imageUrl ?: '/images/default-card.jpg';
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $escapedImage = htmlspecialchars($this->imageUrl, ENT_QUOTES, 'UTF-8');
        $escapedKeyword = htmlspecialchars($this->keyword, ENT_QUOTES, 'UTF-8');

        $html = <<<HTML
<div class="link-card">
    <div class="card-image">
        <img src="{$escapedImage}" alt="{$escapedKeyword}" loading="lazy" />
    </div>
    <div class="card-content">
        <h3 class="card-title">
            <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer">{$escapedTitle}</a>
        </h3>
        <p class="card-description">{$escapedDesc}</p>
        <span class="card-keyword">关键词: {$escapedKeyword}</span>
    </div>
</div>
HTML;

        return $html;
    }

    public function renderWithStyles(): string
    {
        $cardHtml = $this->render();
        $styles = <<<CSS
<style>
.link-card {
    display: flex;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    max-width: 400px;
    background: #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}
.link-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
.card-image {
    flex: 0 0 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
}
.card-image img {
    width: 100%;
    height: auto;
    display: block;
}
.card-content {
    flex: 1;
    padding: 12px 16px;
}
.card-title {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
}
.card-title a {
    color: #1a73e8;
    text-decoration: none;
}
.card-title a:hover {
    text-decoration: underline;
}
.card-description {
    margin: 0 0 8px 0;
    font-size: 14px;
    color: #555;
    line-height: 1.5;
}
.card-keyword {
    font-size: 12px;
    color: #999;
    display: block;
}
</style>
CSS;
        return $styles . "\n" . $cardHtml;
    }
}

function renderLinkCardFromConfig(array $config): string
{
    $url = $config['url'] ?? 'https://official-web-leyu.com.cn';
    $keyword = $config['keyword'] ?? '乐鱼体育';
    $title = $config['title'] ?? '';
    $description = $config['description'] ?? '';
    $imageUrl = $config['image_url'] ?? '';

    $card = new LinkCard($url, $keyword, $title, $description, $imageUrl);
    return $card->renderWithStyles();
}

// 示例用法（可移除）
$sampleConfig = [
    'url' => 'https://official-web-leyu.com.cn',
    'keyword' => '乐鱼体育',
    'title' => '乐鱼体育 - 官方入口',
    'description' => '乐鱼体育提供最新体育赛事直播与资讯，安全可靠。',
    'image_url' => '/images/leyu-banner.jpg',
];

echo renderLinkCardFromConfig($sampleConfig);