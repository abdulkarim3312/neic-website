<div class="left">
    <div class="card">
        <div class="card-header">
            কমিশন পরিচিতি
        </div>
        <div class="card-body">
            <ul>
                @if (count($memberCategories) > 0)
                    @foreach($memberCategories as $cat)
                        <li>
                            <a href="{{ route('member_list', $cat->slug) }}" class="category-link">
                                {{ $cat->name_bn }}
                            </a>
                        </li>
                    @endforeach
                @endif
                <li>
                    <a href="javascript:void(0)" class="category-link">
                        কমিশনের কার্যপরিধি
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="category-link">
                        গেজেট
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.category-link').click(function(e) {
        e.preventDefault();
        let slug = $(this).data('slug');
        alert('ok')
        $.ajax({
            url: '/members/ajax/' + slug,
            method: 'GET',
            success: function(response) {
                $('#members-container').html(response);
            },
            error: function() {
                alert('Failed to load members.');
            }
        });
    });
});
</script>