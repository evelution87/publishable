<?php

namespace Evelution\Publishable\Traits;

use Carbon\Carbon;

trait Publishable {
	
	public function initializePublishable() {
		if ( ! isset( $this->casts[ $this->getPublishedAtColumn() ] ) ) {
			$this->casts[ $this->getPublishedAtColumn() ] = 'datetime';
		}
	}
	
	public function getPublishedAtColumn() {
		return 'published_at';
	}
	
	public function getPublishedAttribute() {
		return ! is_null( $this->{$this->getPublishedAtColumn()} )
			   && $this->{$this->getPublishedAtColumn()} <= Carbon::now();
	}
	
	public function getScheduledAttribute() {
		return ! is_null( $this->{$this->getPublishedAtColumn()} )
			   && $this->{$this->getPublishedAtColumn()} > Carbon::now();
	}
	
	public function getDraftAttribute() {
		return is_null( $this->{$this->getPublishedAtColumn()} );
	}
	
	public function scopePublished( $query ) {
		return $query->whereNotNull( $this->getPublishedAtColumn() )->where( $this->getPublishedAtColumn(), '<=', Carbon::now() );
	}
	
	public function scopeDraft( $query ) {
		return $query->whereNull( $this->getPublishedAtColumn() );
	}
	
	public function scopeScheduled( $query ) {
		return $query->whereNotNull( $this->getPublishedAtColumn() )->where( $this->getPublishedAtColumn(), '>', Carbon::now() );
	}
	
	public function publish_if( $boolean, $save = false, $force = false ) {
		if ( $boolean ) {
			$this->publish( $save, $force );
		} else {
			$this->unpublish( $save );
		}
	}
	
	public function publish( $save = false, $force = false ) {
		if ( $force || is_null( $this->{$this->getPublishedAtColumn()} ) ) {
			$this->{$this->getPublishedAtColumn()} = Carbon::now();
			if ( $save ) {
				$this->save();
			}
		}
	}
	
	public function schedule( $date_time, $save = false ) {
		$this->{$this->getPublishedAtColumn()} = $date_time;
		if ( $save ) {
			$this->save();
		}
	}
	
	public function unpublish( $save = false ) {
		$this->{$this->getPublishedAtColumn()} = null;
		if ( $save ) {
			$this->save();
		}
	}
	
}
