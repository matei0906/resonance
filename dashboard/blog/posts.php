<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - Resonance</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .posts-wrapper {
            max-width: 960px;
            margin: 100px auto;
            padding: 0 20px;
        }

        .create-post {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px var(--shadow-sm);
        }

        .create-post textarea {
            width: 100%;
            min-height: 100px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            resize: vertical;
            margin-bottom: 1rem;
            outline: none;
        }

        .create-post textarea::placeholder {
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-secondary);
        }

        .create-post textarea:focus {
            border-color: var(--border-color);
        }

        .create-post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .post-attachments {
            display: flex;
            gap: 1rem;
        }

        .attachment-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            transition: color 0.3s;
        }

        .attachment-btn:hover {
            color: #9b2c1a;
        }

        .attachment-btn.active {
            color: #9b2c1a;
        }

        /* Music Search Bar */
        .music-search-container {
            position: relative;
        }

        .music-search-bar {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.5rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            box-shadow: 0 5px 20px var(--shadow-sm);
            z-index: 100;
            min-width: 320px;
            box-sizing: border-box;
        }

        .music-search-bar.show {
            display: block;
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .music-search-bar input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 0.9rem;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            outline: none;
            box-sizing: border-box;
        }

        .music-search-bar input:focus {
            border-color: var(--border-color);
            outline: none;
        }

        .music-search-bar input::placeholder {
            color: var(--text-secondary);
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .music-search-results {
            margin-top: 0.5rem;
            max-height: 200px;
            overflow-y: auto;
        }

        .music-search-results .result-item {
            padding: 0.6rem 0.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            color: var(--text-primary);
            transition: background 0.2s;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .music-search-results .result-item:last-child {
            border-bottom: none;
        }

        .music-search-results .result-item:hover {
            background: var(--bg-secondary);
        }

        .music-search-results .result-item img {
            flex-shrink: 0;
        }

        .music-search-results .result-item span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .music-search-input-wrapper {
            display: flex;
            flex-direction: column;
        }

        .music-search-input-wrapper input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        .posts-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .post {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px var(--shadow-sm);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .post-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--bg-secondary);
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9b2c1a;
        }

        .post-user {
            flex: 1;
        }

        .post-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .post-time {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .post-content {
            margin-bottom: 1rem;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .post-actions {
            display: flex;
            gap: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .post-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .post-action:hover {
            color: #9b2c1a;
        }

        .post-action.like-btn.liked {
            color: #e74c3c;
        }

        .post-action.like-btn.liked i {
            color: #e74c3c;
        }

        .post-action.like-btn:hover {
            color: #e74c3c;
        }

        .post-action.like-btn i {
            transition: transform 0.2s;
        }

        .post-action.like-btn:active i {
            transform: scale(1.2);
        }

        .post-media {
            margin: 1rem 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .post-media img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .post-media audio {
            width: 100%;
            margin: 0.5rem 0;
        }

        #noPostsMessage {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
        }

        /* Selected Song Display */
        .selected-song {
            display: none;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.75rem;
            background: var(--bg-secondary);
            border-radius: 6px;
            font-size: 0.85rem;
            color: var(--text-primary);
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 200px;
        }

        .selected-song.show {
            display: flex;
        }

        .selected-song-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .selected-song-remove {
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 0.9rem;
            padding: 0 0.25rem;
            transition: color 0.2s;
        }

        .selected-song-remove:hover {
            color: #c33;
        }

        /* Animated Sound Bars */
        .sound-bars {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 16px;
        }

        .sound-bars .bar {
            width: 3px;
            background: linear-gradient(to top, #9b2c1a, #ff8a3d);
            border-radius: 1px;
            animation: soundBar 0.5s ease-in-out infinite alternate;
        }

        .sound-bars .bar:nth-child(1) {
            height: 40%;
            animation-delay: 0s;
        }

        .sound-bars .bar:nth-child(2) {
            height: 70%;
            animation-delay: 0.1s;
        }

        .sound-bars .bar:nth-child(3) {
            height: 50%;
            animation-delay: 0.2s;
        }

        .sound-bars .bar:nth-child(4) {
            height: 90%;
            animation-delay: 0.3s;
        }

        @keyframes soundBar {
            0% {
                transform: scaleY(0.3);
            }
            100% {
                transform: scaleY(1);
            }
        }

        /* Calendar Styles */
        .calendar-container {
            position: relative;
        }

        .calendar-popup {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.5rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 10px 30px var(--shadow-sm);
            z-index: 100;
            min-width: 300px;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .calendar-popup.show {
            display: block;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .calendar-header h4 {
            margin: 0;
            font-size: 1rem;
            color: var(--text-primary);
        }

        .calendar-nav {
            display: flex;
            gap: 0.5rem;
        }

        .calendar-nav button {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            border-radius: 4px;
            transition: background 0.2s, color 0.2s;
        }

        .calendar-nav button:hover {
            background: var(--bg-secondary);
            color: #9b2c1a;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            margin-bottom: 0.5rem;
        }

        .calendar-weekdays span {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            padding: 0.25rem;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: var(--text-primary);
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            user-select: none;
        }

        .calendar-day:hover:not(.empty):not(.selected) {
            background: var(--bg-secondary);
        }

        .calendar-day.empty {
            cursor: default;
        }

        .calendar-day.today {
            border: 2px solid #9b2c1a;
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%);
            color: white;
        }

        .calendar-day.in-range {
            background: rgba(155, 44, 26, 0.2);
        }

        .calendar-day.past {
            color: var(--text-secondary);
            opacity: 0.5;
        }

        .calendar-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border-color);
        }

        .calendar-actions .selected-count {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .calendar-actions button {
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%);
            border: none;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .calendar-actions button:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(155, 44, 26, 0.3);
        }

        .calendar-actions .clear-btn {
            background: none;
            color: var(--text-secondary);
            padding: 0.4rem 0.75rem;
        }

        .calendar-actions .clear-btn:hover {
            color: #c33;
            transform: none;
            box-shadow: none;
        }

        /* Selected Dates Display */
        .selected-dates {
            display: none;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.75rem;
            background: var(--bg-secondary);
            border-radius: 6px;
            font-size: 0.85rem;
            color: var(--text-primary);
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .selected-dates.show {
            display: flex;
        }

        .selected-dates i {
            color: #9b2c1a;
        }

        .selected-dates-remove {
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 0.9rem;
            padding: 0 0.25rem;
            transition: color 0.2s;
        }

        .selected-dates-remove:hover {
            color: #c33;
        }

        /* Post Availability Button */
        .post-availability {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%);
            color: white;
            border: none;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .post-availability:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(155, 44, 26, 0.3);
        }

        /* Availability Modal */
        .availability-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .availability-modal.show {
            display: flex;
        }

        .availability-modal-content {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            max-width: 400px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .availability-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .availability-modal-header h3 {
            margin: 0;
            color: var(--text-primary);
        }

        .availability-modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .availability-dates-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .availability-date-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: var(--bg-secondary);
            border-radius: 6px;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .availability-date-item i {
            color: #9b2c1a;
        }

        /* Post Header with Menu */
        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .post-menu {
            position: relative;
            margin-left: auto;
        }

        .post-menu-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background 0.2s;
            font-size: 1rem;
        }

        .post-menu-btn:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .post-menu-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 5px 20px var(--shadow-sm);
            min-width: 120px;
            z-index: 50;
            overflow: hidden;
        }

        .post-menu-dropdown.show {
            display: block;
        }

        .post-menu-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            cursor: pointer;
            transition: background 0.2s;
            font-size: 0.9rem;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .post-menu-item:hover {
            background: var(--bg-secondary);
        }

        .post-menu-item.delete {
            color: #e74c3c;
        }

        .post-menu-item.delete:hover {
            background: rgba(231, 76, 60, 0.1);
        }

        /* Post Header Extras (song and availability) - positioned after username */
        .post-header-extras {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 0.75rem;
            flex-shrink: 0;
        }

        /* Post Song Display - Compact for header */
        .post-song {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.6rem;
            background: var(--bg-secondary);
            border-radius: 6px;
            font-size: 0.8rem;
            color: var(--text-primary);
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            max-width: 180px;
        }

        .post-song:hover {
            background: var(--border-color);
        }

        .post-song .sound-bars {
            flex-shrink: 0;
            height: 14px;
        }

        .post-song .sound-bars .bar {
            width: 2px;
        }

        .post-song-info {
            overflow: hidden;
        }

        .post-song-title {
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.75rem;
        }

        .post-song-artist {
            font-size: 0.7rem;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Post Availability Button - Icon only */
        .post-availability-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            padding: 0;
            background: var(--bg-secondary);
            border: none;
            border-radius: 6px;
            color: #9b2c1a;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .post-availability-btn:hover {
            background: var(--border-color);
            transform: scale(1.1);
        }

        .post-availability-btn span {
            display: none;
        }

        /* Calendar View Modal */
        .calendar-view-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .calendar-view-modal.show {
            display: flex;
        }

        .calendar-view-content {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            max-width: 350px;
            width: 90%;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .calendar-view-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .calendar-view-header h3 {
            margin: 0;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .calendar-view-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .calendar-view-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .calendar-view-nav button {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            border-radius: 4px;
            transition: background 0.2s, color 0.2s;
        }

        .calendar-view-nav button:hover {
            background: var(--bg-secondary);
            color: #9b2c1a;
        }

        .calendar-view-month {
            font-weight: 600;
            color: var(--text-primary);
        }

        .calendar-view-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            margin-bottom: 0.5rem;
        }

        .calendar-view-weekdays span {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            padding: 0.25rem;
        }

        .calendar-view-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .calendar-view-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: var(--text-primary);
            border-radius: 6px;
            cursor: default;
            user-select: none;
        }

        .calendar-view-day.empty {
            color: transparent;
        }

        .calendar-view-day.available {
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%);
            color: white;
            font-weight: 600;
        }

        .calendar-view-day.today {
            border: 2px solid #9b2c1a;
        }

        .calendar-view-day.other-month {
            color: var(--text-secondary);
            opacity: 0.5;
        }

        /* Delete Confirmation Modal */
        .delete-confirm-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1001;
            justify-content: center;
            align-items: center;
        }

        .delete-confirm-modal.show {
            display: flex;
        }

        .delete-confirm-content {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            max-width: 400px;
            width: 90%;
            position: relative;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .delete-confirm-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            line-height: 1;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.2s, color 0.2s;
        }

        .delete-confirm-close:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .delete-confirm-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            padding-right: 2rem;
        }

        .delete-confirm-message {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .delete-confirm-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .delete-confirm-btn {
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .delete-confirm-btn.cancel {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .delete-confirm-btn.cancel:hover {
            background: var(--border-color);
        }

        .delete-confirm-btn.delete {
            background: #dc3545;
            border: none;
            color: white;
        }

        .delete-confirm-btn.delete:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-brand">
                <a href="../index.html" class="logo-link">
                    <img src="../../assets/images/resonance.png" alt="Resonance Logo" class="logo-image">
                    <h1 class="logo">Resonance</h1>
                </a>
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="../index.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="../profile/account.php" class="nav-link">My Account</a></li>
                <li class="nav-item"><a href="../profile/settings.php" class="nav-link">Settings</a></li>
            </ul>
            <div class="nav-actions">
                <button class="btn btn-outline" id="logoutBtn">Log Out</button>
            </div>
            <button class="theme-toggle" aria-label="Toggle dark mode">
                <i class="fas fa-moon theme-icon"></i>
            </button>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <main class="posts-wrapper">
        <div class="create-post">
            <textarea id="postContent" placeholder="Share your musical thoughts, find bandmates, or schedule jam sessions..."></textarea>
            <div class="create-post-actions">
                <div class="post-attachments">
                    <button type="button" class="attachment-btn" id="photoBtn" title="Upload Photo">
                        <i class="fas fa-image"></i>
                    </button>
                    <div class="music-search-container">
                        <button type="button" class="attachment-btn" id="musicBtn" title="Add Music">
                            <i class="fas fa-music"></i>
                        </button>
                        <div class="music-search-bar" id="musicSearchBar">
                            <div class="music-search-input-wrapper">
                                <input type="text" id="musicSearchInput" placeholder="Search for a song or artist...">
                            </div>
                            <div class="music-search-results" id="musicSearchResults"></div>
                        </div>
                    </div>
                    <div class="calendar-container">
                        <button type="button" class="attachment-btn" id="calendarBtn" title="Schedule Event">
                            <i class="fas fa-calendar"></i>
                        </button>
                        <div class="calendar-popup" id="calendarPopup">
                            <div class="calendar-header">
                                <h4 id="calendarMonth">December 2025</h4>
                                <div class="calendar-nav">
                                    <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                                    <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                            <div class="calendar-weekdays">
                                <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                            </div>
                            <div class="calendar-days" id="calendarDays"></div>
                            <div class="calendar-actions">
                                <span class="selected-count" id="selectedCount">0 dates selected</span>
                                <div>
                                    <button class="clear-btn" id="clearDates">Clear</button>
                                    <button id="confirmDates">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="selected-dates" id="selectedDatesDisplay">
                        <i class="fas fa-calendar-check"></i>
                        <span id="selectedDatesText">3 dates</span>
                        <span class="selected-dates-remove" id="removeDates" title="Remove dates">&times;</span>
                    </div>
                    <div class="selected-song" id="selectedSong">
                        <div class="sound-bars">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </div>
                        <span class="selected-song-text" id="selectedSongText"></span>
                        <span class="selected-song-remove" id="removeSong" title="Remove song">&times;</span>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="submitPost">Post</button>
            </div>
        </div>

        <div class="posts-list" id="postsList">
            <div id="noPostsMessage">No posts yet. Be the first to share something!</div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                    <div class="footer-section">
                    <h3>Resonance</h3>
                    <p class="ws-regular">Break free from group chats,<br>join a musician-run community.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="./auth/quiz.html">Create an Account</a></li>
                        <li><a href="./auth/login.html">Log In</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="https://github.com/matei0906/" class="social-link" aria-label="GitHub"><i class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/in/matei-stoica-698aa4348/" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Resonance. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Availability Modal (old - list view) -->
    <div class="availability-modal" id="availabilityModal">
        <div class="availability-modal-content">
            <div class="availability-modal-header">
                <h3>Available Dates</h3>
                <button class="availability-modal-close" id="closeAvailabilityModal">&times;</button>
            </div>
            <div class="availability-dates-list" id="availabilityDatesList"></div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="delete-confirm-modal" id="deleteConfirmModal">
        <div class="delete-confirm-content">
            <button class="delete-confirm-close" id="deleteConfirmClose">&times;</button>
            <div class="delete-confirm-title">Delete Post</div>
            <div class="delete-confirm-message">Are you sure you want to delete this post? This action cannot be undone.</div>
            <div class="delete-confirm-actions">
                <button class="delete-confirm-btn delete" id="confirmDeleteBtn">Yes, delete</button>
                <button class="delete-confirm-btn cancel" id="cancelDeleteBtn">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Calendar View Modal -->
    <div class="calendar-view-modal" id="calendarViewModal">
        <div class="calendar-view-content">
            <div class="calendar-view-header">
                <h3>Available Dates</h3>
                <button class="calendar-view-close" id="closeCalendarView">&times;</button>
            </div>
            <div class="calendar-view-nav">
                <button id="calendarViewPrev"><i class="fas fa-chevron-left"></i></button>
                <span class="calendar-view-month" id="calendarViewMonth">December 2025</span>
                <button id="calendarViewNext"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="calendar-view-weekdays">
                <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
            </div>
            <div class="calendar-view-days" id="calendarViewDays"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="config.local.js"></script>
    <script src="../../assets/js/auth.js"></script>
    <script type="module">
        import { checkSession, requireLogin, logout } from '../../assets/js/auth.js';

        console.log('Posts page loading, checking session...');
        
        // Ensure user is logged in
        requireLogin();

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');
            const submitPostBtn = document.getElementById('submitPost');
            const postContent = document.getElementById('postContent');
            const postsList = document.getElementById('postsList');

            // Handle logout
            logoutBtn.addEventListener('click', logout);

            // Music search bar toggle
            const musicBtn = document.getElementById('musicBtn');
            const musicSearchBar = document.getElementById('musicSearchBar');
            const musicSearchInput = document.getElementById('musicSearchInput');
            const musicSearchResults = document.getElementById('musicSearchResults');

            // Selected song display
            const selectedSongEl = document.getElementById('selectedSong');
            const selectedSongText = document.getElementById('selectedSongText');
            const removeSongBtn = document.getElementById('removeSong');
            let selectedSongData = null;

            // Calendar functionality
            const calendarBtn = document.getElementById('calendarBtn');
            const calendarPopup = document.getElementById('calendarPopup');
            const calendarDays = document.getElementById('calendarDays');
            const calendarMonth = document.getElementById('calendarMonth');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const selectedCountEl = document.getElementById('selectedCount');
            const clearDatesBtn = document.getElementById('clearDates');
            const confirmDatesBtn = document.getElementById('confirmDates');
            const selectedDatesDisplay = document.getElementById('selectedDatesDisplay');
            const selectedDatesText = document.getElementById('selectedDatesText');
            const removeDatesBtn = document.getElementById('removeDates');
            const availabilityModal = document.getElementById('availabilityModal');
            const availabilityDatesList = document.getElementById('availabilityDatesList');
            const closeAvailabilityModal = document.getElementById('closeAvailabilityModal');

            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();
            let selectedDates = [];
            let isDragging = false;
            let dragStartDate = null;

            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                               'July', 'August', 'September', 'October', 'November', 'December'];

            function renderCalendar() {
                const firstDay = new Date(currentYear, currentMonth, 1).getDay();
                const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                calendarMonth.textContent = `${monthNames[currentMonth]} ${currentYear}`;
                calendarDays.innerHTML = '';

                // Empty cells for days before first day of month
                for (let i = 0; i < firstDay; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'calendar-day empty';
                    calendarDays.appendChild(emptyCell);
                }

                // Days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'calendar-day';
                    dayCell.textContent = day;
                    
                    const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const dateObj = new Date(currentYear, currentMonth, day);
                    
                    if (dateObj < today) {
                        dayCell.classList.add('past');
                    } else {
                        dayCell.dataset.date = dateStr;
                        
                        if (dateObj.getTime() === today.getTime()) {
                            dayCell.classList.add('today');
                        }
                        
                        if (selectedDates.includes(dateStr)) {
                            dayCell.classList.add('selected');
                        }

                        // Mousedown starts potential drag
                        dayCell.addEventListener('mousedown', function(e) {
                            if (dayCell.classList.contains('past')) return;
                            e.preventDefault();
                            dragStartDate = dateStr;
                            isDragging = false; // Not dragging yet, just pressed
                        });

                        // Mouseenter while button held = dragging
                        dayCell.addEventListener('mouseenter', function() {
                            if (dragStartDate && !dayCell.classList.contains('past') && dateStr !== dragStartDate) {
                                isDragging = true; // Now we're actually dragging
                                selectRange(dragStartDate, dateStr);
                            }
                        });

                        // Mouseup on a cell - if not dragging, it's a click
                        dayCell.addEventListener('mouseup', function() {
                            if (dragStartDate && !isDragging) {
                                // Single click - toggle this date
                                toggleDate(dateStr);
                            }
                            dragStartDate = null;
                            isDragging = false;
                        });
                    }

                    calendarDays.appendChild(dayCell);
                }

                updateSelectedCount();
            }

            function toggleDate(dateStr) {
                const index = selectedDates.indexOf(dateStr);
                if (index > -1) {
                    selectedDates.splice(index, 1);
                } else {
                    selectedDates.push(dateStr);
                }
                selectedDates.sort();
                renderCalendar();
            }

            function selectRange(start, end) {
                const startDate = new Date(start);
                const endDate = new Date(end);
                
                if (startDate > endDate) {
                    [startDate, endDate] = [endDate, startDate];
                }

                const current = new Date(startDate);
                while (current <= endDate) {
                    const dateStr = current.toISOString().split('T')[0];
                    if (!selectedDates.includes(dateStr)) {
                        selectedDates.push(dateStr);
                    }
                    current.setDate(current.getDate() + 1);
                }
                selectedDates.sort();
                renderCalendar();
            }

            function updateSelectedCount() {
                const count = selectedDates.length;
                selectedCountEl.textContent = `${count} date${count !== 1 ? 's' : ''} selected`;
            }

            // Stop dragging on mouseup (outside calendar)
            document.addEventListener('mouseup', function(e) {
                if (!e.target.closest('.calendar-day')) {
                    // Released outside a day cell - if we had a start date and didn't drag, it was cancelled
                    dragStartDate = null;
                    isDragging = false;
                }
            });

            // Calendar toggle
            calendarBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                calendarPopup.classList.toggle('show');
                calendarBtn.classList.toggle('active');
                if (calendarPopup.classList.contains('show')) {
                    renderCalendar();
                }
            });

            // Close calendar when clicking outside
            document.addEventListener('click', function(e) {
                if (!calendarPopup.contains(e.target) && e.target !== calendarBtn && !e.target.closest('.calendar-container')) {
                    calendarPopup.classList.remove('show');
                    calendarBtn.classList.remove('active');
                }
            });

            // Month navigation
            prevMonthBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar();
            });

            // Clear dates
            clearDatesBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                selectedDates = [];
                renderCalendar();
            });

            // Confirm dates
            confirmDatesBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                calendarPopup.classList.remove('show');
                calendarBtn.classList.remove('active');
                
                if (selectedDates.length > 0) {
                    selectedDatesDisplay.classList.add('show');
                    selectedDatesText.textContent = `${selectedDates.length} date${selectedDates.length !== 1 ? 's' : ''}`;
                } else {
                    selectedDatesDisplay.classList.remove('show');
                }
            });

            // Remove dates
            removeDatesBtn.addEventListener('click', function() {
                selectedDates = [];
                selectedDatesDisplay.classList.remove('show');
            });

            // Availability modal
            closeAvailabilityModal.addEventListener('click', function() {
                availabilityModal.classList.remove('show');
            });

            availabilityModal.addEventListener('click', function(e) {
                if (e.target === availabilityModal) {
                    availabilityModal.classList.remove('show');
                }
            });

            window.showAvailability = function(datesJson) {
                const dates = JSON.parse(datesJson);
                availabilityDatesList.innerHTML = dates.map(date => {
                    const d = new Date(date);
                    const formatted = d.toLocaleDateString('en-US', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                    return `<div class="availability-date-item"><i class="fas fa-calendar-check"></i>${formatted}</div>`;
                }).join('');
                availabilityModal.classList.add('show');
            };

            musicBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                musicSearchBar.classList.toggle('show');
                musicBtn.classList.toggle('active');
                if (musicSearchBar.classList.contains('show')) {
                    musicSearchInput.focus();
                }
            });

            // Close search bar when clicking outside
            document.addEventListener('click', function(e) {
                if (!musicSearchBar.contains(e.target) && e.target !== musicBtn) {
                    musicSearchBar.classList.remove('show');
                    musicBtn.classList.remove('active');
                }
            });

            // Handle music search with YouTube API
            // API key loaded from config.local.js (gitignored for security)
            const YOUTUBE_API_KEY = typeof CONFIG !== 'undefined' ? CONFIG.YOUTUBE_API_KEY : '';
            
            let searchTimeout = null;

            async function performMusicSearch() {
                const query = musicSearchInput.value.trim();
                if (query.length < 2) {
                    musicSearchResults.innerHTML = '';
                    return;
                }

                // Show loading state
                musicSearchResults.innerHTML = '<div class="result-item">Searching...</div>';

                try {
                    const response = await fetch(
                        `https://www.googleapis.com/youtube/v3/search?` +
                        `part=snippet&type=video&videoCategoryId=10&maxResults=5` +
                        `&q=${encodeURIComponent(query + ' music')}` +
                        `&key=${YOUTUBE_API_KEY}`
                    );

                    if (!response.ok) {
                        throw new Error('YouTube API request failed');
                    }

                    const data = await response.json();

                    if (data.items && data.items.length > 0) {
                        musicSearchResults.innerHTML = data.items.map(item => {
                            const title = item.snippet.title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                            const artist = item.snippet.channelTitle.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                            return `
                            <div class="result-item" onclick="addYouTubeToPost('${item.id.videoId}', '${title}', '${artist}')">
                                <img src="${item.snippet.thumbnails.default.url}" alt="" style="width: 40px; height: 30px; border-radius: 4px; margin-right: 8px; vertical-align: middle;">
                                <span>${item.snippet.title.substring(0, 50)}${item.snippet.title.length > 50 ? '...' : ''}</span>
                            </div>
                        `}).join('');
                    } else {
                        musicSearchResults.innerHTML = '<div class="result-item">No results found</div>';
                    }
                } catch (error) {
                    console.error('YouTube search error:', error);
                    musicSearchResults.innerHTML = '<div class="result-item" style="color: #c33;">Search failed. Check API key.</div>';
                }
            }

            // Auto-search as user types (with debounce)
            musicSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performMusicSearch, 400);
            });

            // Add YouTube video to post
            window.addYouTubeToPost = function(videoId, title, artist) {
                // Store the selected song data
                selectedSongData = {
                    videoId: videoId,
                    title: title,
                    artist: artist,
                    url: `https://www.youtube.com/watch?v=${videoId}`
                };

                // Show the selected song display with artist
                selectedSongText.textContent = `${title} - ${artist}`;
                selectedSongEl.classList.add('show');

                // Close the search bar
                musicSearchBar.classList.remove('show');
                musicBtn.classList.remove('active');
                musicSearchInput.value = '';
                musicSearchResults.innerHTML = '';
            };

            // Remove selected song
            removeSongBtn.addEventListener('click', function() {
                selectedSongData = null;
                selectedSongEl.classList.remove('show');
                selectedSongText.textContent = '';
            });


            // Handle post submission
            submitPostBtn.addEventListener('click', async function() {
                let content = postContent.value.trim();
                
                // Append song if selected
                if (selectedSongData) {
                    const songText = `\n🎵 ${selectedSongData.title} - ${selectedSongData.artist}\n${selectedSongData.url}`;
                    content = content ? content + songText : songText.trim();
                }

                // Append availability dates if selected
                let availabilityData = null;
                if (selectedDates.length > 0) {
                    availabilityData = [...selectedDates].sort();
                    const datesText = `\n📅 Available: ${selectedDates.length} date${selectedDates.length !== 1 ? 's' : ''}`;
                    content = content ? content + datesText : datesText.trim();
                }

                console.log('Submitting post with:', { content, availability_dates: availabilityData, selectedDates });

                if (!content) return;

                submitPostBtn.disabled = true;
                
                try {
                    const token = localStorage.getItem('session_token');
                    const requestBody = { 
                        content,
                        availability_dates: availabilityData
                    };
                    console.log('Request body:', JSON.stringify(requestBody));
                    
                    const response = await fetch('../../api/create_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(requestBody)
                    });

                    if (!response.ok) {
                        throw new Error('Failed to create post');
                    }

                    // Clear the textarea, selected song, and dates
                    postContent.value = '';
                    selectedSongData = null;
                    selectedSongEl.classList.remove('show');
                    selectedSongText.textContent = '';
                    selectedDates = [];
                    selectedDatesDisplay.classList.remove('show');
                    
                    // Refresh posts
                    loadPosts();
                } catch (error) {
                    console.error('Error creating post:', error);
                    alert('Failed to create post. Please try again.');
                } finally {
                    submitPostBtn.disabled = false;
                }
            });

            async function loadPosts() {
                try {
                    const token = localStorage.getItem('session_token');
                    const response = await fetch('../../api/get_posts.php', {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load posts');
                    }

                    const posts = await response.json();
                    
                    if (posts.error) {
                        throw new Error(posts.error);
                    }
                    
                    if (posts.length === 0) {
                        postsList.innerHTML = '<div id="noPostsMessage">No posts yet. Be the first to share something!</div>';
                        return;
                    }

                    console.log('Loaded posts:', posts.map(p => ({ id: p.id, availability_dates: p.availability_dates })));
                    
                    postsList.innerHTML = posts.map(post => {
                        // Check for availability dates
                        const hasAvailability = post.availability_dates && post.availability_dates.length > 0;
                        
                        // Check for song in content
                        let songDisplay = '';
                        const songMatch = post.content.match(/🎵\s*(.+?)\s*-\s*(.+?)(?:\n|$)/);
                        if (songMatch) {
                            const songTitle = songMatch[1].trim();
                            const songArtist = songMatch[2].trim();
                            const youtubeMatch = post.content.match(/https:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/);
                            const videoId = youtubeMatch ? youtubeMatch[1] : '';
                            songDisplay = `
                                <div class="post-song" onclick="${videoId ? `window.open('https://www.youtube.com/watch?v=${videoId}', '_blank')` : ''}" title="${songTitle} - ${songArtist}">
                                    <div class="sound-bars">
                                        <span class="bar"></span>
                                        <span class="bar"></span>
                                        <span class="bar"></span>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="post-song-info">
                                        <div class="post-song-title">${songTitle}</div>
                                        <div class="post-song-artist">${songArtist}</div>
                                    </div>
                                </div>
                            `;
                        }
                        
                        // Availability button (calendar icon only)
                        const availabilityBtn = hasAvailability 
                            ? `<button class="post-availability-btn" data-dates='${JSON.stringify(post.availability_dates)}' title="Check Availability">
                                <i class="fas fa-calendar-alt"></i>
                               </button>`
                            : '';
                        
                        // Filter out song/availability text from display content
                        let displayContent = post.content
                            .replace(/🎵\s*.+?\n?https:\/\/www\.youtube\.com\/watch\?v=[a-zA-Z0-9_-]+/g, '')
                            .replace(/📅\s*Available:\s*\d+\s*dates?/g, '')
                            .trim();
                        
                        const likeCount = post.like_count || 0;
                        const userLiked = post.user_liked || false;
                        const heartIcon = userLiked ? 'fas fa-heart' : 'far fa-heart';
                        const likedClass = userLiked ? 'liked' : '';
                        const likeText = likeCount > 0 ? `${likeCount} Like${likeCount !== 1 ? 's' : ''}` : 'Like';
                        
                        return `
                        <article class="post" data-post-id="${post.id}" data-user-id="${post.user_id}">
                            <div class="post-header">
                                <div class="post-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="post-user">
                                    <div class="post-name">${post.first_name} ${post.last_name}</div>
                                    <div class="post-time">${new Date(post.created_at).toLocaleString()}</div>
                                </div>
                                <div class="post-header-extras">
                                    ${songDisplay}
                                    ${availabilityBtn}
                                </div>
                                <div class="post-menu">
                                    <button class="post-menu-btn" onclick="togglePostMenu(this)">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="post-menu-dropdown">
                                        <div class="post-menu-item delete" onclick="deletePost(${post.id})">
                                            <i class="fas fa-trash"></i> Delete
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${displayContent ? `<div class="post-content">${displayContent}</div>` : ''}
                            <div class="post-actions">
                                <div class="post-action like-btn ${likedClass}" data-post-id="${post.id}">
                                    <i class="${heartIcon}"></i>
                                    <span class="like-text">${likeText}</span>
                                </div>
                                <div class="post-action">
                                    <i class="far fa-comment"></i>
                                    <span>Comment</span>
                                </div>
                                <div class="post-action">
                                    <i class="far fa-share-square"></i>
                                    <span>Share</span>
                                </div>
                            </div>
                        </article>
                    `}).join('');

                    // Add like button event listeners
                    document.querySelectorAll('.like-btn').forEach(btn => {
                        btn.addEventListener('click', handleLike);
                    });

                    // Close any open menus when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('.post-menu')) {
                            document.querySelectorAll('.post-menu-dropdown.show').forEach(menu => {
                                menu.classList.remove('show');
                            });
                        }
                    });

                } catch (error) {
                    console.error('Error loading posts:', error);
                    postsList.innerHTML = '<div class="error-message">Failed to load posts. Please try again later.</div>';
                }
            }

            // Handle like button click
            async function handleLike(e) {
                const btn = e.currentTarget;
                const postId = btn.dataset.postId;
                const icon = btn.querySelector('i');
                const text = btn.querySelector('.like-text');
                
                // Disable button temporarily
                btn.style.pointerEvents = 'none';
                
                try {
                    const token = localStorage.getItem('session_token');
                    const response = await fetch('../../api/toggle_like.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify({ post_id: parseInt(postId) })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to toggle like');
                    }

                    const data = await response.json();
                    
                    // Update UI
                    if (data.liked) {
                        btn.classList.add('liked');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        btn.classList.remove('liked');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                    
                    const count = data.like_count;
                    text.textContent = count > 0 ? `${count} Like${count !== 1 ? 's' : ''}` : 'Like';
                    
                } catch (error) {
                    console.error('Error toggling like:', error);
                } finally {
                    btn.style.pointerEvents = 'auto';
                }
            }

            // Toggle post menu
            window.togglePostMenu = function(btn) {
                event.stopPropagation();
                const dropdown = btn.nextElementSibling;
                
                // Close all other menus first
                document.querySelectorAll('.post-menu-dropdown.show').forEach(menu => {
                    if (menu !== dropdown) menu.classList.remove('show');
                });
                
                dropdown.classList.toggle('show');
            };

            // Delete confirmation modal
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const deleteConfirmClose = document.getElementById('deleteConfirmClose');
            let pendingDeletePostId = null;

            function showDeleteConfirm(postId) {
                pendingDeletePostId = postId;
                deleteConfirmModal.classList.add('show');
            }

            function hideDeleteConfirm() {
                deleteConfirmModal.classList.remove('show');
                pendingDeletePostId = null;
            }

            deleteConfirmClose.addEventListener('click', hideDeleteConfirm);
            cancelDeleteBtn.addEventListener('click', hideDeleteConfirm);
            
            deleteConfirmModal.addEventListener('click', function(e) {
                if (e.target === deleteConfirmModal) {
                    hideDeleteConfirm();
                }
            });

            confirmDeleteBtn.addEventListener('click', async function() {
                if (!pendingDeletePostId) return;
                
                const postId = pendingDeletePostId;
                hideDeleteConfirm();
                
                try {
                    const token = localStorage.getItem('session_token');
                    const response = await fetch('../../api/delete_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify({ post_id: postId })
                    });

                    const data = await response.json();
                    
                    if (!response.ok) {
                        alert(data.error || 'Failed to delete post');
                        return;
                    }

                    // Remove post from DOM
                    const postEl = document.querySelector(`[data-post-id="${postId}"]`);
                    if (postEl) {
                        postEl.remove();
                    }
                    
                    // Check if no posts left
                    if (document.querySelectorAll('.post').length === 0) {
                        postsList.innerHTML = '<div id="noPostsMessage">No posts yet. Be the first to share something!</div>';
                    }
                } catch (error) {
                    console.error('Error deleting post:', error);
                    alert('Failed to delete post. Please try again.');
                }
            });

            // Delete post - show confirmation
            window.deletePost = function(postId) {
                showDeleteConfirm(postId);
            };

            // Calendar View Modal
            const calendarViewModal = document.getElementById('calendarViewModal');
            const calendarViewDays = document.getElementById('calendarViewDays');
            const calendarViewMonth = document.getElementById('calendarViewMonth');
            const calendarViewPrev = document.getElementById('calendarViewPrev');
            const calendarViewNext = document.getElementById('calendarViewNext');
            const closeCalendarView = document.getElementById('closeCalendarView');
            
            let viewMonth = new Date().getMonth();
            let viewYear = new Date().getFullYear();
            let viewDates = [];

            function renderCalendarView() {
                const firstDay = new Date(viewYear, viewMonth, 1).getDay();
                const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                calendarViewMonth.textContent = `${monthNames[viewMonth]} ${viewYear}`;
                calendarViewDays.innerHTML = '';

                // Empty cells
                for (let i = 0; i < firstDay; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'calendar-view-day empty';
                    emptyCell.textContent = '';
                    calendarViewDays.appendChild(emptyCell);
                }

                // Days
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'calendar-view-day';
                    dayCell.textContent = day;
                    
                    const dateStr = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const dateObj = new Date(viewYear, viewMonth, day);
                    
                    if (dateObj.getTime() === today.getTime()) {
                        dayCell.classList.add('today');
                    }
                    
                    if (viewDates.includes(dateStr)) {
                        dayCell.classList.add('available');
                    }
                    
                    calendarViewDays.appendChild(dayCell);
                }
            }

            window.showCalendarView = function(dates) {
                viewDates = Array.isArray(dates) ? dates : JSON.parse(dates);
                
                // Start with the first available date's month
                if (viewDates.length > 0) {
                    const firstDate = new Date(viewDates[0]);
                    viewMonth = firstDate.getMonth();
                    viewYear = firstDate.getFullYear();
                }
                
                renderCalendarView();
                calendarViewModal.classList.add('show');
            };
            
            // Event delegation for availability buttons
            document.addEventListener('click', function(e) {
                const availBtn = e.target.closest('.post-availability-btn');
                if (availBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    const datesStr = availBtn.getAttribute('data-dates');
                    if (datesStr) {
                        try {
                            const dates = JSON.parse(datesStr);
                            showCalendarView(dates);
                        } catch (err) {
                            console.error('Error parsing dates:', err);
                        }
                    }
                }
            });

            calendarViewPrev.addEventListener('click', function() {
                viewMonth--;
                if (viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderCalendarView();
            });

            calendarViewNext.addEventListener('click', function() {
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderCalendarView();
            });

            closeCalendarView.addEventListener('click', function() {
                calendarViewModal.classList.remove('show');
            });

            calendarViewModal.addEventListener('click', function(e) {
                if (e.target === calendarViewModal) {
                    calendarViewModal.classList.remove('show');
                }
            });

            // Initial load
            loadPosts();

            // Reload posts periodically
            setInterval(loadPosts, 30000); // Every 30 seconds
        });
    </script>
    <script src="../../assets/js/theme.js"></script>
</body>
</html>