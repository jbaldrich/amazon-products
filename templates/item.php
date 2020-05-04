<?php foreach ($this->context->items as $item) : ?>
    <article>
        <a href="<?php echo esc_attr($item->url()); ?>" rel="nofollow">
            <div class="img-cont">
                <img
                        src="<?php echo esc_attr($item->image()); ?>"
                        title="<?php echo esc_attr($item->title()); ?>"
                >
            </div>
        </a>
        <div class='show-more-button' style='display:none;' alt='ver más información'>+</div>
        <div class='feature-list'>
            <a href='<?php echo esc_attr($item->url()); ?>' rel='nofollow'>
                <h2 class='article-text'>
                    <?php echo esc_html($item->title()); ?>
                </h2>
            </a>
            <a href='<?php echo esc_attr($item->url()); ?>' rel='nofollow'>
                <p class='article-text article-price'>
                    <?php echo esc_html($item->price()); ?>
                </p>
            </a>
            <ul>
                <?php foreach($item->features() as $feature) : ?>
                    <li class='article-text'>
                        <?php echo esc_html($feature); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button>
            <a href='<?php echo esc_attr($item->moreLikeThatUrl()); ?>' rel='nofollow'>Más como este</a>
        </button>
    </article>
<?php endforeach; ?>
