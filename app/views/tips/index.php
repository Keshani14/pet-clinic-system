<?php
$pageTitle = 'Pet Health Tips — Pet Clinic';
$bodyClass = 'dashboard-layout';

$extraHead = '
<style>
    .tips-header {
        margin-bottom: 30px;
    }
    
    .search-filter-wrap {
        background: var(--white);
        padding: 25px;
        border-radius: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .search-input-group {
        position: relative;
        flex: 1;
    }

    .search-input-group .icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: var(--pink-400);
    }

    .search-input-group input {
        width: 100%;
        padding: 15px 15px 15px 45px;
        border: 2px solid var(--pink-50);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--pink-50);
    }

    .search-input-group input:focus {
        border-color: var(--pink-400);
        background: white;
        box-shadow: 0 0 0 4px rgba(232, 67, 143, 0.1);
        outline: none;
    }

    .category-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-chip {
        padding: 8px 20px;
        border-radius: 30px;
        background: var(--pink-50);
        color: var(--gray-600);
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s ease;
        border: 2px solid transparent;
    }

    .filter-chip:hover {
        background: var(--pink-100);
        color: var(--pink-600);
    }

    .filter-chip.active {
        background: var(--pink-500);
        color: white;
        box-shadow: 0 4px 12px rgba(232, 67, 143, 0.3);
    }

    .tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .tip-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        animation: slideUp 0.5s ease forwards;
    }

    .tip-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 45px rgba(232, 67, 143, 0.15);
    }

    .tip-category-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 800;
        color: var(--pink-400);
        background: var(--pink-50);
        padding: 4px 10px;
        border-radius: 6px;
    }

    .tip-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .tip-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--gray-800);
        margin-bottom: 15px;
    }

    .tip-content {
        color: var(--gray-600);
        line-height: 1.6;
        font-size: 0.95rem;
        flex: 1;
    }

    .tip-tags {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag {
        font-size: 0.75rem;
        color: var(--gray-400);
    }

    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px;
        background: var(--white);
        border-radius: 20px;
        display: none;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
';

require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/owner_sidebar.php'; ?>
    
    <main class="main-content">
        <div class="tips-header">
            <h1 class="hero-title" style="text-align: left; font-size: 2.2rem;">Health & <span>Care Tips</span></h1>
            <p class="text-gray-600">Expert advice to keep your furry friends happy and healthy.</p>
        </div>

        <div class="search-filter-wrap">
            <div class="search-input-group">
                <span class="icon">🔍</span>
                <input type="text" id="tipSearch" placeholder="Search for tips (e.g. food, dental, fleas)...">
            </div>
            
            <div class="category-filters" id="categoryFilters">
                <div class="filter-chip active" data-category="all">All Tips</div>
                <div class="filter-chip" data-category="Nutrition">Nutrition</div>
                <div class="filter-chip" data-category="Hygiene">Hygiene</div>
                <div class="filter-chip" data-category="Exercise">Exercise</div>
                <div class="filter-chip" data-category="Preventive">Preventive</div>
                <div class="filter-chip" data-category="Mental Health">Mental Health</div>
            </div>
        </div>

        <div class="tips-grid" id="tipsGrid">
            <!-- Personalized Link to Vaccinations -->
            <div class="tip-card" data-category="Preventive" data-tags="vaccinations safety pet-wise" style="border: 2px solid var(--pink-100);">
                <span class="tip-category-badge" style="background: var(--pink-500); color: white;">NEW</span>
                <div class="tip-icon">💉</div>
                <h3 class="tip-title">Pet-Specific Vaccinations</h3>
                <p class="tip-content">We've created a personalized vaccination schedule based on your pets' species and age. Check what's required for your furry friends.</p>
                <div style="margin-top: 15px;">
                    <a href="?url=vaccination/index" class="btn-pill" style="padding: 8px 15px; font-size: 0.8rem; display: inline-block;">View My Schedule →</a>
                </div>
            </div>

            <?php foreach ($tips as $tip): ?>
                <div class="tip-card" data-category="<?php echo $tip['category']; ?>" data-tags="<?php echo implode(' ', $tip['tags']); ?>">
                    <span class="tip-category-badge"><?php echo htmlspecialchars($tip['category']); ?></span>
                    <div class="tip-icon"><?php echo $tip['icon']; ?></div>
                    <h3 class="tip-title"><?php echo htmlspecialchars($tip['title']); ?></h3>
                    <p class="tip-content"><?php echo htmlspecialchars($tip['content']); ?></p>
                    <div class="tip-tags">
                        <?php foreach ($tip['tags'] as $tag): ?>
                            <span class="tag">#<?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="no-results" id="noResults">
                <div class="icon-lg">🐕💨</div>
                <h3>No tips found matching your search.</h3>
                <p>Try different keywords or browse all categories.</p>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('tipSearch');
        const filterChips = document.querySelectorAll('.filter-chip');
        const tipCards = document.querySelectorAll('.tip-card');
        const noResults = document.getElementById('noResults');
        
        let currentCategory = 'all';
        let currentSearch = '';

        function filterTips() {
            let visibleCount = 0;
            
            tipCards.forEach(card => {
                const category = card.getAttribute('data-category');
                const title = card.querySelector('.tip-title').textContent.toLowerCase();
                const content = card.querySelector('.tip-content').textContent.toLowerCase();
                const tags = card.getAttribute('data-tags').toLowerCase();
                
                const matchesCategory = (currentCategory === 'all' || category === currentCategory);
                const matchesSearch = title.includes(currentSearch) || 
                                    content.includes(currentSearch) || 
                                    tags.includes(currentSearch);
                
                if (matchesCategory && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            noResults.style.display = (visibleCount === 0) ? 'block' : 'none';
        }

        // Search Input Event
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value.toLowerCase();
            filterTips();
        });

        // Category Filter Event
        filterChips.forEach(chip => {
            chip.addEventListener('click', () => {
                filterChips.forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                currentCategory = chip.getAttribute('data-category');
                filterTips();
            });
        });
    });
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
