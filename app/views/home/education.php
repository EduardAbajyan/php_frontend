<ul class="list">
<?php foreach ($educationData as $index => $education): ?>
                    <li class="list-item"
                        style="--item-index: <?php echo $index ?>; --icon-url: url('<?php
                                                                        switch ($education['platform_type']) {
                                                                            case 'bacherol':
                                                                                echo base_url('images/bacherol_degree.png');
                                                                                break;
                                                                            case 'udemy':
                                                                                echo base_url('images/udemy.png');
                                                                                break;
                                                                            case 'book':
                                                                                echo base_url('images/book.png');
                                                                                break;
                                                                            case 'mosh':
                                                                                echo base_url('images/mosh.png');
                                                                                break;
                                                                            default:
                                                                                echo 'default_icon.png';
                                                                                break;
                                                                        } ?>');"
                        data-info="<?php echo htmlspecialchars($education['link'] ?? ''); ?>">
                        <h1><?php echo htmlspecialchars($education['faculty_name']) ?></h1>
                        <h2><?php echo htmlspecialchars($education['platform_name']) ?>, <?php echo htmlspecialchars($education['starting_year']) ?> - <?php echo htmlspecialchars($education['ending_year']) ?></h2>
                    </li>
<?php endforeach; ?>
                </ul>
