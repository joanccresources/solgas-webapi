<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ContentSocialNetwork;
use App\Models\Employment;
use App\Models\EmploymentArea;
use App\Models\EmploymentType;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\LeadDistributor;
use App\Models\LeadEmailDestination;
use App\Models\LeadServiceStation;
use App\Models\LeadWorkWithUs;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\PageField;
use App\Models\PageMultipleContent;
use App\Models\PageMultipleField;
use App\Models\PageMultipleFieldData;
use App\Models\PageMultipleFieldSection;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Attribute;
use App\Models\Comment;
use App\Models\ContentFooter;
use App\Models\ContentFooterMenu;
use App\Models\ContentHeader;
use App\Models\ContentHeaderMenu;
use App\Models\CookieConsent;
use App\Models\Map;
use App\Models\SustainabilityReport;
use App\Models\SustainabilityReportObject;
use App\Observers\LeadDistributorObserver;
use App\Observers\LeadObserver;
use App\Observers\LeadServiceStationObserver;
use App\Observers\LeadWorkWithUsObserver;
use App\Policies\v1\ActivityPolicy;
use Spatie\Activitylog\Models\Activity;
use App\Policies\v1\AttributePolicy;
use App\Policies\v1\CategoryPolicy;
use App\Policies\v1\CommentPolicy;
use App\Policies\v1\ContentFooterMenuPolicy;
use App\Policies\v1\ContentFooterPolicy;
use App\Policies\v1\ContentHeaderMenuPolicy;
use App\Policies\v1\ContentHeaderPolicy;
use App\Policies\v1\ContentSocialNetworkPolicy;
use App\Policies\v1\CookieConsentPolicy;
use App\Policies\v1\EmploymentAreaPolicy;
use App\Policies\v1\EmploymentPolicy;
use App\Policies\v1\EmploymentTypePolicy;
use App\Policies\v1\GeneralInformationPolicy;
use App\Policies\v1\LeadDistributorPolicy;
use App\Policies\v1\LeadEmailDestinationPolicy;
use App\Policies\v1\LeadPolicy;
use App\Policies\v1\LeadServiceStationPolicy;
use App\Policies\v1\LeadWorkWithUsPolicy;
use App\Policies\v1\MapPolicy;
use App\Policies\v1\ModulePolicy;
use App\Policies\v1\PageContentPolicy;
use App\Policies\v1\PageFieldPolicy;
use App\Policies\v1\PageMultipleContentPolicy;
use App\Policies\v1\PageMultipleFieldDataPolicy;
use App\Policies\v1\PageMultipleFieldPolicy;
use App\Policies\v1\PageMultipleFieldSectionPolicy;
use App\Policies\v1\PagePolicy;
use App\Policies\v1\PageSectionPolicy;
use App\Policies\v1\PermissionPolicy;
use App\Policies\v1\PostPolicy;
use App\Policies\v1\RolePolicy;
use App\Policies\v1\SustainabilityReportObjectPolicy;
use App\Policies\v1\SustainabilityReportPolicy;
use App\Policies\v1\TagPolicy;
use App\Policies\v1\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Module::class, ModulePolicy::class);
        Gate::policy(Attribute::class, AttributePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(ContentSocialNetwork::class, ContentSocialNetworkPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(PageSection::class, PageSectionPolicy::class);
        Gate::policy(PageContent::class, PageContentPolicy::class);
        Gate::policy(PageField::class, PageFieldPolicy::class);
        Gate::policy(PageMultipleContent::class, PageMultipleContentPolicy::class);
        Gate::policy(PageMultipleField::class, PageMultipleFieldPolicy::class);
        Gate::policy(PageMultipleFieldData::class, PageMultipleFieldDataPolicy::class);
        Gate::policy(PageMultipleFieldSection::class, PageMultipleFieldSectionPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

        Gate::policy(Lead::class, LeadPolicy::class);
        Gate::policy(LeadWorkWithUs::class, LeadWorkWithUsPolicy::class);
        Gate::policy(LeadServiceStation::class, LeadServiceStationPolicy::class);
        Gate::policy(LeadEmailDestination::class, LeadEmailDestinationPolicy::class);
        Gate::policy(LeadDistributor::class, LeadDistributorPolicy::class);
        Gate::policy(EmploymentType::class, EmploymentTypePolicy::class);
        Gate::policy(Employment::class, EmploymentPolicy::class);
        Gate::policy(EmploymentArea::class, EmploymentAreaPolicy::class);
        Gate::policy(GeneralInformation::class, GeneralInformationPolicy::class);
        Gate::policy(Activity::class, ActivityPolicy::class);
        Gate::policy(ContentFooter::class, ContentFooterPolicy::class);
        Gate::policy(ContentFooterMenu::class, ContentFooterMenuPolicy::class);
        Gate::policy(ContentHeader::class, ContentHeaderPolicy::class);
        Gate::policy(ContentHeaderMenu::class, ContentHeaderMenuPolicy::class);
        Gate::policy(SustainabilityReport::class, SustainabilityReportPolicy::class);
        Gate::policy(SustainabilityReportObject::class, SustainabilityReportObjectPolicy::class);
        Gate::policy(Map::class, MapPolicy::class);
        Gate::policy(CookieConsent::class, CookieConsentPolicy::class);

        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('Superadministrador')) {
                return true;
            }
        });

        //Observers
        LeadDistributor::observe(LeadDistributorObserver::class);
        Lead::observe(LeadObserver::class);
        LeadServiceStation::observe(LeadServiceStationObserver::class);
        LeadWorkWithUs::observe(LeadWorkWithUsObserver::class);
    }
}
